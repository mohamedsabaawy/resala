<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;

class Status extends Component
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
            $statuses = \App\Models\Status::withTrashed()->paginate(10); // statuses paginate
        }else{
            $statuses = \App\Models\Status::paginate(10); // statuses paginate
        }
        return view('livewire.admin.status',compact('statuses'));
    }

    public function save(){
        $this->valid();
        $status = \App\Models\Status::create([
            'name'=>$this->name,
            'branch_id'=>session('branch_id'),
        ]);
        if ($status){
            $this->resetInput();
            $this->dispatch('close');
            $this->dispatch('notify');
        }
    }


    //get one status
    public function show($id){
        $this->isUpdate=true;
        $status = $this->withTrash ? \App\Models\Status::withTrashed()->find($id) : \App\Models\Status::find($id);
        $this->id = $status->id;
        $this->name = $status->name;
        $this->deleted_at = $status->deleted_at;
    }

    public function update(){
        $this->valid();
        $status = \App\Models\Status::find($this->id);
        if ($status){
            $status->update([
                'name'=>$this->name,
                'branch_id'=>session('branch_id'),
            ]);
        }
        $this->resetInput();
        $this->dispatch('close');
        $this->dispatch('notify');
    }

    public function delete(){
        $status = $this->withTrash ? \App\Models\Status::withTrashed()->find($this->id) : \App\Models\Status::find($this->id);

        if($this->deleted_at)
        {
            $status->forceDelete();
        }else {
            $status->delete();
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
