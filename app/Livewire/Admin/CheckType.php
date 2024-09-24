<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;

class CheckType extends Component
{
    use WithPagination;
    public $id, $name,$active;
    public $showCreate=false;
    public $isUpdate=false;
    public function render()
    {
        $checkTypes = \App\Models\CheckType::paginate(10); // branches paginate
        return view('livewire.admin.check-type',compact('checkTypes'));
    }


    public function save(){
        $this->valid();
        $branch = \App\Models\CheckType::create([
            'name'=>$this->name,
            'active'=>$this->active,
            'branch_id'=>auth()->user()->branch_id,
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
        $branch = \App\Models\CheckType::find($id);
        $this->id = $branch->id;
        $this->name = $branch->name;
    }

    public function update(){
        $this->valid();
        $barnch = \App\Models\CheckType::find($this->id);
        if ($barnch){
            $barnch->update([
                'name'=>$this->name,
                'active'=>$this->active,
                'branch_id'=>auth()->user()->branch_id,
            ]);
        }
        $this->dispatch('close');
        $this->dispatch('notify');
    }

    public function delete(){
        $branch = \App\Models\CheckType::find($this->id);
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
            'active' => 'required',
        ],[
            'name.required'=>'برجاء ادخل اسم الاختبار',
            'active.required'=>'برجاء ادخل عدد حالة الاختبار',
        ]);
    }
}
