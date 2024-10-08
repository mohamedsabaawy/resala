<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;

class Qualification extends Component
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
            $qualifications = \App\Models\Qualification::withTrashed()->paginate(10); // qualifications paginate
        }else{
            $qualifications = \App\Models\Qualification::paginate(10); // qualifications paginate
        }
        return view('livewire.admin.qualification',compact('qualifications'));
    }

    public function save(){
        $this->valid();
        $qualification = \App\Models\Qualification::create([
            'name'=>$this->name,
            'branch_id'=>session('branch_id'),
        ]);
        if ($qualification){
            $this->resetInput();
            $this->dispatch('close');
            $this->dispatch('notify');
        }
    }


    //get one qualification
    public function show($id){
        $this->isUpdate=true;
        $qualification = $this->withTrash ? \App\Models\Qualification::withTrashed()->find($id) : \App\Models\Qualification::find($id);
        $this->id = $qualification->id;
        $this->name = $qualification->name;
        $this->deleted_at = $qualification->deleted_at;
    }

    public function update(){
        $this->valid();
        $qualification = \App\Models\Qualification::find($this->id);
        if ($qualification){
            $qualification->update([
                'name'=>$this->name,
                'branch_id'=>session('branch_id'),
            ]);
        }
        $this->resetInput();
        $this->dispatch('close');
        $this->dispatch('notify');
    }

    public function delete(){
        $qualification = $this->withTrash ? \App\Models\Qualification::withTrashed()->find($this->id) : \App\Models\Qualification::find($this->id);

        if($this->deleted_at)
        {
            $qualification->forceDelete();
        }else {
            $qualification->delete();
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
