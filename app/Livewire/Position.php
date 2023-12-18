<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class Position extends Component
{
    use WithPagination;
    public $id, $name;
    public $showCreate=false;
    public $isUpdate=false;
    public function render()
    {
        $positions = \App\Models\Position::paginate(10); // branches paginate
        return view('livewire.position',compact('positions'));
    }


    public function save(){
        $this->valid();
        $branch = \App\Models\Position::create([
            'name'=>$this->name,
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
        $branch = \App\Models\Position::find($id);
        $this->id = $branch->id;
        $this->name = $branch->name;
    }

    public function update(){
        $this->valid();
        $barnch = \App\Models\Position::find($this->id);
        if ($barnch){
            $barnch->update([
                'name'=>$this->name,
            ]);
        }
        $this->dispatch('close');
        $this->dispatch('notify');
    }

    public function delete(){
        $branch = \App\Models\Position::find($this->id);
        $branch->delete();
        $this->dispatch('close');
        $this->dispatch('notify');
    }

    public function resetInput(){
        $this->id = "";
        $this->name = "";
    }
    private function valid(){
        $validated = $this->validate([
            'name' => 'required|min:3',
        ],[
            'name.required'=>'برجاء ادخل اسم المستوي',
        ]);
    }
}
