<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;

class Degree extends Component
{
    use WithPagination;
    public $id;
    public string $name;
    public $deleted_at;
    public bool $showCreate=false;
    public bool $isUpdate=false;
    public bool $withTrash=false;


    public function render()
    {
        if ($this->withTrash){
            $degrees = \App\Models\Degree::withTrashed()->paginate(10); // degrees paginate
        }else{
            $degrees = \App\Models\Degree::paginate(10); // degrees paginate
        }
        return view('livewire.admin.degree',compact('degrees'));
    }

    public function save(){
        $this->valid();
        $degree = \App\Models\Degree::create([
            'name'=>$this->name,
        ]);
        if ($degree){
            $this->resetInput();
            $this->dispatch('close');
            $this->dispatch('notify');
        }
    }


    //get one degree
    public function show($id){
        $this->isUpdate=true;
        $degree = $this->withTrash ? \App\Models\Degree::withTrashed()->find($id) : \App\Models\Degree::find($id);
        $this->id = $degree->id;
        $this->name = $degree->name;
        $this->deleted_at = $degree->deleted_at;
    }

    public function update(){
        $this->valid();
        $barnch = \App\Models\Degree::find($this->id);
        if ($barnch){
            $barnch->update([
                'name'=>$this->name,
                'address'=>$this->address,
            ]);
        }
        $this->resetInput();
        $this->dispatch('close');
        $this->dispatch('notify');
    }

    public function delete(){
        $degree = $this->withTrash ? \App\Models\Degree::withTrashed()->find($this->id) : \App\Models\Degree::find($this->id);

        if($this->deleted_at)
        {
            $degree->forceDelete();
        }else {
            $degree->delete();
        }
        $this->dispatch('close');
        $this->dispatch('notify');
        $this->resetInput();
    }


    public function resetInput(){
        $this->reset(['name','id','showCreate','isUpdate','deleted_at']);
    }
    private function valid(){
        $validated = $this->validate([
            'name' => 'required|min:3',
        ]);
    }
}
