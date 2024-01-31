<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;

class MaritalStatus extends Component
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
            $maritalStatuses = \App\Models\MaritalStatus::withTrashed()->paginate(10); // maritalStatuses paginate
        }else{
            $maritalStatuses = \App\Models\MaritalStatus::paginate(10); // maritalStatuses paginate
        }
        return view('livewire.admin.marital-status',compact('maritalStatuses'));
    }

    public function save(){
        $this->valid();
        $maritalStatus = \App\Models\MaritalStatus::create([
            'name'=>$this->name,
        ]);
        if ($maritalStatus){
            $this->resetInput();
            $this->dispatch('close');
            $this->dispatch('notify');
        }
    }


    //get one maritalStatus
    public function show($id){
        $this->isUpdate=true;
        $maritalStatus = $this->withTrash ? \App\Models\MaritalStatus::withTrashed()->find($id) : \App\Models\MaritalStatus::find($id);
        $this->id = $maritalStatus->id;
        $this->name = $maritalStatus->name;
        $this->deleted_at = $maritalStatus->deleted_at;
    }

    public function update(){
        $this->valid();
        $maritalStatus = \App\Models\MaritalStatus::find($this->id);
        if ($maritalStatus){
            $maritalStatus->update([
                'name'=>$this->name,
            ]);
        }
        $this->resetInput();
        $this->dispatch('close');
        $this->dispatch('notify');
    }

    public function delete(){
        $maritalStatus = $this->withTrash ? \App\Models\MaritalStatus::withTrashed()->find($this->id) : \App\Models\MaritalStatus::find($this->id);

        if($this->deleted_at)
        {
            $maritalStatus->forceDelete();
        }else {
            $maritalStatus->delete();
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
