<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;

class Category extends Component
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
            $categories = \App\Models\Category::withTrashed()->paginate(10); // categories paginate
        }else{
            $categories = \App\Models\Category::paginate(10); // categories paginate
        }
        return view('livewire.admin.category',compact('categories'));
    }

    public function save(){
        $this->valid();
        $category = \App\Models\Category::create([
            'name'=>$this->name,
        ]);
        if ($category){
            $this->resetInput();
            $this->dispatch('close');
            $this->dispatch('notify');
        }
    }


    //get one category
    public function show($id){
        $this->isUpdate=true;
        $category = $this->withTrash ? \App\Models\Category::withTrashed()->find($id) : \App\Models\Category::find($id);
        $this->id = $category->id;
        $this->name = $category->name;
        $this->deleted_at = $category->deleted_at;
    }

    public function update(){
        $this->valid();
        $category = \App\Models\Category::find($this->id);
        if ($category){
            $category->update([
                'name'=>$this->name,
            ]);
        }
        $this->resetInput();
        $this->dispatch('close');
        $this->dispatch('notify');
    }

    public function delete(){
        $category = $this->withTrash ? \App\Models\Category::withTrashed()->find($this->id) : \App\Models\Category::find($this->id);

        if($this->deleted_at)
        {
            $category->forceDelete();
        }else {
            $category->delete();
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
