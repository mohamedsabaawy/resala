<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class Event extends Component
{
    use WithPagination;
    public $id, $name, $details,$from=null,$to=null,$team_id,$date;
    public $showCreate=false;
    public $isUpdate=false;
    public function render()
    {
        $events = \App\Models\Event::paginate(10); // branches paginate
        return view('livewire.event',compact('events'));
    }


    public function save(){
        $this->valid();
        $branch = \App\Models\Event::create([
            'name'=>$this->name,
            'details'=>$this->details,
            'from'=>$this->from ,
            'to'=>$this->to,
//            'team_id'=>$this->team_id,
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
        $branch = \App\Models\Event::find($id);
        $this->id = $branch->id;
        $this->name = $branch->name;
        $this->details = $branch->details;
        $this->from = $branch->from;
        $this->to = $branch->to;
    }

    public function update(){
        $this->valid();
        $barnch = \App\Models\Event::find($this->id);
        if ($barnch){
            $barnch->update([
                'name'=>$this->name,
                'details'=>$this->details,
                'from'=>$this->from,
                'to'=>$this->to,
//                'team_id'=>$this->team_id,
            ]);
        }
        $this->dispatch('close');
        $this->dispatch('notify');
    }

    public function delete(){
        $branch = \App\Models\Event::find($this->id);
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
            'details'=>'required|min:3',
            'from'=>'required|date',
            'to'=>'required|date|after_or_equal:from',
        ],[
            'name.required'=>'برجاء ادخل اسم الحدث',
            'details.required'=>'برجاء ادخل تفاصيل الحدث',
            'from.required'=>'برجاء ادخل تاريخ بداية الحدث',
            'to.required'=>'برجاء ادخل تاريخ نهاية الحدث الحدث',
        ]);
    }
}
