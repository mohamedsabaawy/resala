<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;

class Team extends Component
{
    use WithPagination;
    public $id, $name, $manager,$count;
    public $showCreate=false;
    public $isUpdate=false;
    public function render()
    {
        $teams = \App\Models\Team::paginate(10); // branches paginate
        return view('livewire.admin.team',compact('teams'));
    }


    public function save(){
        $this->valid();
        $branch = \App\Models\Team::create([
            'name'=>$this->name,
            'count'=>$this->count,
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
        $branch = \App\Models\Team::find($id);
        $this->id = $branch->id;
        $this->name = $branch->name;
        $this->count = $branch->count;
    }

    public function update(){
        $this->valid();
        $barnch = \App\Models\Team::find($this->id);
        if ($barnch){
            $barnch->update([
                'name'=>$this->name,
                'count'=>$this->count,
            ]);
        }
        $this->dispatch('close');
        $this->dispatch('notify');
    }

    public function delete(){
        $branch = \App\Models\Team::find($this->id);
        $branch->delete();
        $this->dispatch('close');
        $this->dispatch('notify');
    }

    public function resetInput(){
        $this->id = "";
        $this->name = "";
        $this->manager = "";
        $this->count = "";
    }
    private function valid(){
        $validated = $this->validate([
            'name' => 'required|min:3',
            'count' => 'required|numeric|min:1',
        ],[
            'name.required'=>'برجاء ادخل اسم الفريق',
            'count.required'=>'برجاء ادخل عدد افراد الفريق',
            'count.min'=>'برجاء ادخال رقم اكبر من او يساوي :min',
        ]);
    }
}
