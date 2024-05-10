<?php

namespace App\Livewire\User;

use App\Exports\UsersExport;
use App\Models\Activity;
use App\Models\Event;
use App\Models\Job;
use App\Models\User;
use App\Rules\Check;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Home extends Component
{
    use WithPagination;

    public $isUpdate = false,
        $isApologize = false,
        $id, $users, $userId,
        $user_id, $event_id,
        $comment, $supervisor_comment,
        $activity_date, $type, $events,
        $event_from = null,
        $event_to = null,
        $filter_from = null, //filter
        $filter_to = null,
        $msg = '',
        $job,
        $search;

    public function render()
    {
        $jobs = Job::select('name', 'id')->get();
        $users = User::OwenUser()->with(['position', 'activities' => function ($quary) {
            $quary->where([
                ['approval', 1],
                ['activity_date', '>=', $this->filter_from],
                ['activity_date', '<=', $this->filter_to],
            ]);
        }])->orderBy('code');
        $this->customFilter($users);
        $this->users = $users->pluck('name', 'id');
        $allUsers = $users->paginate(10);
        $this->events = Event::where([
            ['from', '>=', ($this->activity_date ?? today())],
            ['active', 1]
        ])->orWhere([['type', 1], ['active', 1]])->get();
        return view('livewire.user.home', compact(['allUsers','jobs']));
    }

    public function mount()
    {
        $this->filter_from = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->filter_to = Carbon::now()->endOfMonth()->format('Y-m-d');
    }
    public function export()
    {
        $filter_from = $this->filter_from ?? date_format(today(), "Y-m-01");
        $filter_to = $this->filter_to ?? date_format(today(), "Y-m-t");
//        dd($filter_from);
        $users = \App\Models\User::OwenUser()->with(['team', 'position', 'activities' => function ($query) use ($filter_from) {
            $query->where([
                ['activity_date', '>=', $filter_from],
                ['approval', 1]
            ]);
        }])->get()->sortBy('team_id');
        return Excel::download(new UsersExport($users, $filter_from, $filter_to), 'users.xlsx');
    }

    public function save()
    {
        $msg = '';
        $this->valid();
        $users = User::with(['job', 'activities'])->whereIn('id', $this->userId)->get();
        foreach ($users as $user) {
            if (count($user->activities->where('activity_date', $this->activity_date)) > 0) {
                $msg .= "- $user->name \n";
                continue;
            }
            $manager = optional($user->job)->manager_id;
            $activity = Activity::create([
                'activity_date' => $this->activity_date,
                'comment' => $this->comment,
                'event_id' => $this->event_id,
                'user_id' => $user->id,
                'add_by' => Auth::id(),
//                'type' => $this->type,
                'apologize' => $this->isApologize ? '1' : '0',
                'approval' => $user->job->manager_id == Auth::id() ? 1 : 0,
                'manager_id' => $manager,
            ]);
        }

//        foreach ($this->userId as $userId) {
//            $manager = null;//
//            if (User::Find($userId)->job->manager_id)
//                $manager = User::Find($userId)->job->manager_id;
//            $activity = Activity::create([
//                'activity_date' => $this->activity_date,
//                'comment' => $this->comment,
//                'event_id' => $this->event_id,
//                'user_id' => Auth::user()->role != "user" ? $userId : Auth::id(),
//                'add_by' => Auth::id(),
////                'type' => $this->type,
//                'apologize' => $this->isApologize ? '1' : '0',
//                'approval' => User::Find($userId)->job->manager_id == Auth::id() ? 1 : 0,
//                'manager_id' => $manager,
//            ]);
//        }

        if ($activity) {
            $this->msg = $msg;
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
        $activity = \App\Models\Activity::find($this->id);
        if ($activity) {
            $activity->update([
                'activity_date' => $this->activity_date,
                'comment' => $this->comment,
                'event_id' => $this->event_id,
                'type' => $this->type,
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
        $this->resetExcept(['filter_from', 'filter_to', 'msg']);
    }

    private function valid()
    {

        $validated = $this->validate([
//            'type' => $this->isApologize ? 'nullable' : "required",
            'activity_date' => ['required', new Check($this->user_id)],
            'comment' => 'required',
            'userId' => 'required',
            'userId.*' => [Rule::in(User::all()->pluck('id'))],
            'event_id' => 'required',
        ]);
    }

    public function createApologize()
    {
        $this->resetInput();
        $this->isApologize = true;
    }

    public function check()
    {
        if ($event = Event::find($this->event_id))
            if ($event->type == 0) {
                $this->event_from = $event->from;
                $this->event_to = $event->to;
            }
    }

    protected function customFilter($users){
        if (strlen($this->search) > 0) {
            $users = $users->Where('code', 'like', "%$this->search%")
                ->orWhere('name', 'like', "%$this->search%")
                ->orWhere('phone', 'like', "%$this->search%")
                ->orWhere('email', 'like', "%$this->search%");
        }

        if ($this->job)
            $users = $users->where('job_id',$this->job);

        return $users;
    }


}
