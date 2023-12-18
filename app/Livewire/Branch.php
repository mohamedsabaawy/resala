<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

//use App\Models\Branch;


class Branch extends Component
{
    use WithPagination;
    public $id;
    public $name;
    public $showCreate=false;
    public $address=null;
    public $manager;
    public $isUpdate=false;


    public function render()
    {
        $branches = \App\Models\Branch::paginate(10); // branches paginate
        return view('livewire.branch',compact('branches'));
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
        $branch = \App\Models\Branch::find($id);
        $this->id = $branch->id;
        $this->name = $branch->name;
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
        $this->dispatch('close');
        $this->dispatch('notify');
    }

    public function delete(){
        $branch = \App\Models\Branch::find($this->id);
        $branch->delete();
        $this->dispatch('close');
        $this->dispatch('notify');
    }

    public function resetInput(){
        $this->reset();
    }
    private function valid(){
        $validated = $this->validate([
            'name' => 'required|min:3',
        ],[
            'name.required'=>'برجاء ادخل اسم الفرع'
        ]);
    }
}
