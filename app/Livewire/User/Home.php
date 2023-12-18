<?php

namespace App\Livewire\User;

use App\Models\Activity;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Home extends Component
{
    use WithPagination;
    public $isUpdate=false ,$id, $user_id,$event_id,$comment,$supervisor_comment,$activity_date,$type,$events;

    public function render()
    {
        $activities = Activity::where('user_id',Auth::id())->paginate(10);
        $this->events = Event::where('from','>=',($this->activity_date ?? today()))->get();
        return view('livewire.user.home',compact(['activities']));
    }

    public function save(){

        $this->valid();
        $activity = \App\Models\Activity::create([
            'activity_date'=>$this->activity_date,
            'comment'=>$this->comment,
            'event_id'=>$this->event_id,
            'user_id'=>Auth::id(),
        ]);
        if ($activity){
            $this->resetInput();
            $this->dispatch('close');
            $this->dispatch('notify');
        }
    }


    //get one activity
    public function show($id){
        $this->isUpdate=true;
        $activity = \App\Models\Activity::find($id);
        $this->id = $activity->id;
        $this->activity_date = $activity->activity_date;
        $this->comment = $activity->comment;
        $this->type = $activity->type;
        $this->event_id = $activity->event_id;
    }

    public function update(){
        $this->valid();
        $barnch = \App\Models\Activity::find($this->id);
        if ($barnch){
            $barnch->update([
                'activity_date'=>$this->activity_date,
                'comment'=>$this->comment,
                'event_id'=>$this->event_id,
            ]);
        }
        $this->dispatch('close');
        $this->dispatch('notify');
    }

    public function delete(){
        $activity = \App\Models\Activity::find($this->id);
        $activity->delete();
        $this->dispatch('close');
        $this->dispatch('notify');
    }

    public function resetInput(){
        $this->reset();
    }
    private function valid(){
        $validated = $this->validate([
            'type' => 'required',
            'activity_date' => 'required',
        ],[
            'activity_date.required'=>'برجاء ادخل تاريخ المشاركة',
            'type.type'=>'اختر نوع المشاركة'
        ]);
    }

}
