<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;

class Nationality extends Component
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
            $nationalities = \App\Models\Nationality::withTrashed()->paginate(10); // nationalities paginate
        }else{
            $nationalities = \App\Models\Nationality::paginate(10); // nationalities paginate
        }
        return view('livewire.admin.nationality',compact('nationalities'));
    }

    public function save(){
        $this->valid();
        $nationality = \App\Models\Nationality::create([
            'name'=>$this->name,
        ]);
        if ($nationality){
            $this->resetInput();
            $this->dispatch('close');
            $this->dispatch('notify');
        }
    }


    //get one nationality
    public function show($id){
        $this->isUpdate=true;
        $nationality = $this->withTrash ? \App\Models\Nationality::withTrashed()->find($id) : \App\Models\Nationality::find($id);
        $this->id = $nationality->id;
        $this->name = $nationality->name;
        $this->deleted_at = $nationality->deleted_at;
    }

    public function update(){
        $this->valid();
        $nationality = \App\Models\Nationality::find($this->id);
        if ($nationality){
            $nationality->update([
                'name'=>$this->name,
                'address'=>$this->address,
            ]);
        }
        $this->resetInput();
        $this->dispatch('close');
        $this->dispatch('notify');
    }

    public function delete(){
        $nationality = $this->withTrash ? \App\Models\Nationality::withTrashed()->find($this->id) : \App\Models\Nationality::find($this->id);

        if($this->deleted_at)
        {
            $nationality->forceDelete();
        }else {
            $nationality->delete();
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
