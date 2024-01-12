<?php

namespace App\Livewire\User;

use App\Models\Activity;
use App\Models\Event;
use App\Models\Position;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Home extends Component
{
    use WithPagination;
    public $isUpdate = false,$isApologize=false, $id, $users, $userId, $user_id, $event_id, $comment, $supervisor_comment, $activity_date, $type, $events;

    public function render()
    {
        $activities = Activity::where('user_id', Auth::id())->paginate(10);
        $this->users = User::with(['position','activities'])->where([
            ['branch_id',Auth::user()->branch_id],
            ['team_id',Auth::user()->team_id]
        ])->get(); //

        //select users if user role not 'user' and check if it admin or not
        if (Auth::user()->role == "user") {
            $this->userId = Auth::id();
            $this->users = $this->users->where('id',$this->userId);
        }
        if (Auth::user()->role == "supervisor") {
            $this->users = $this->users->where('role','<>','admin');
        }
        $this->users = $this->users->pluck('name','id');
        $this->events = Event::where('to', '>=', ($this->activity_date ?? today()))->get();
        return view('livewire.user.home', compact(['activities']));
    }


    public function save()
    {

        $this->valid();
        $activity = \App\Models\Activity::create([
            'activity_date' => $this->activity_date,
            'comment' => $this->comment,
            'event_id' => $this->event_id,
            'user_id' => Auth::user()->role != "user" ? $this->userId : Auth::id(),
            'add_by' => Auth::id(),
            'apologize' => $this->isApologize,
        ]);
        if ($activity) {
            $this->resetInput();
            $this->dispatch('close');
            $this->dispatch('notify');
        }
    }


    //get one activity
    public function show($id)
    {
        $this->isUpdate = true;
        $activity = \App\Models\Activity::find($id);
        $this->id = $activity->id;
        $this->activity_date = $activity->activity_date;
        $this->comment = $activity->comment;
        $this->type = $activity->type;
        $this->event_id = $activity->event_id;
    }

    public function update()
    {
        $this->valid();
        $barnch = \App\Models\Activity::find($this->id);
        if ($barnch) {
            $barnch->update([
                'activity_date' => $this->activity_date,
                'comment' => $this->comment,
                'event_id' => $this->event_id,
            ]);
        }
        $this->resetInput();
        $this->dispatch('close');
        $this->dispatch('notify');
    }

    public function delete()
    {
        $activity = \App\Models\Activity::find($this->id);
        $activity->delete();
        $this->dispatch('close');
        $this->dispatch('notify');
    }

    public function resetInput()
    {
        $this->reset();
    }

    private function valid()
    {
        $validated = $this->validate([
            'type' => $this->isApologize ? 'nullable' : "required",
            'activity_date' => 'required',
            'comment' => 'required',
        ], [
            'activity_date.required' => 'برجاء ادخل تاريخ المشاركة',
            'type.required' => 'اختر نوع المشاركة',
            'comment.required' => 'برجاء كتابة تعليق',
        ]);
    }

}
