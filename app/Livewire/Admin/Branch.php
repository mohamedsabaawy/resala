<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Artisan;
use Livewire\Component;
use Livewire\WithPagination;



class Branch extends Component
{
    use WithPagination;
    public $id;
    public string $name;
    public $deleted_at;
    public bool $showCreate=false;
    public $address=null;
    public $manager;
    public bool $isUpdate=false;
    public bool $withTrash=false;


    public function render()
    {
        if ($this->withTrash){
            $branches = \App\Models\Branch::withTrashed()->paginate(10); // branches paginate
        }else{
            $branches = \App\Models\Branch::paginate(10); // branches paginate
        }
        return view('livewire.admin.branch',compact('branches'));
    }

    public function save(){
        $this->valid();
        $branch = \App\Models\Branch::create([
            'name'=>$this->name,
            'address'=>$this->address,
        ]);
        if ($branch){
            $this->resetInput();
            $this->dispatch('close');
            $this->dispatch('notify');
        }
    }


    //get one branch
    public function show($id){
        $this->isUpdate=true;
        $branch = $this->withTrash ? \App\Models\Branch::withTrashed()->find($id) : \App\Models\Branch::find($id);
        $this->id = $branch->id;
        $this->name = $branch->name;
        $this->deleted_at = $branch->deleted_at;
        $this->address = $branch->address;
    }

    public function update(){
        $this->valid();
        $barnch = \App\Models\Branch::find($this->id);
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
        $branch = $this->withTrash ? \App\Models\Branch::withTrashed()->find($this->id) : \App\Models\Branch::find($this->id);

        if($this->deleted_at)
        {
            $branch->forceDelete();
        }else {
            $branch->delete();
        }
        $this->dispatch('close');
        $this->dispatch('notify');
        $this->resetInput();
    }


    public function resetInput(){
        $this->reset(['name','id','address','showCreate','isUpdate','deleted_at']);
    }
    private function valid(){
        $validated = $this->validate([
            'name' => 'required|min:3',
        ]);
    }
}
