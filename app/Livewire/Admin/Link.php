<?php

namespace App\Livewire\Admin;

use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Link extends Component
{

    use WithPagination;
    public $id, $name, $link,$photo;
    public $showCreate=false;
    public $isUpdate=false;
    public function render()
    {
        $links = \App\Models\Link::paginate(10); // link paginate
        return view('livewire.admin.link',compact('links'));
    }

    public function save(){
        $this->valid();
        $link = \App\Models\Link::create([
            'name'=>$this->name,
            'link'=>$this->link,
        ]);
        if ($link){
            $this->resetInput();
            $this->dispatch('close');
            $this->dispatch('notify');
        }
    }


    //get one link
    public function show($id){
        $this->isUpdate=true;
        $link = \App\Models\Link::find($id);
        $this->id = $link->id;
        $this->name = $link->name;
        $this->link = $link->link;
    }

    public function update(){
        $this->valid();
        $link = \App\Models\Link::find($this->id);
        if ($link){
            $link->update([
                'name'=>$this->name,
                'link'=>$this->link,
            ]);
        }
        $this->dispatch('close');
        $this->dispatch('notify');
    }

    public function delete(){
        $link = \App\Models\Link::find($this->id);
        $link->delete();
        $this->dispatch('close');
        $this->dispatch('notify');
    }

    public function resetInput(){
        $this->id = "";
        $this->name = "";
        $this->link = "";
        $this->photo = "";
    }
    private function valid(){
        $validated = $this->validate([
            'name' => 'required|min:3',
            'link' => 'required',
        ]);
    }
}
