<?php

namespace App\Livewire\Admin;

use App\Exports\MeetingsExport;
use App\Exports\UsersExport;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;


class Meeting extends Component
{
    use AuthorizesRequests;
    use WithPagination;

    public $id, $title, $date, $count, $comment, $status='0', $user_id, $add_by, $position_id, $team_id, $branch_id, $deleted_at,$users,$filter_from,$filter_to,$meets,$jobs,$job_id;
    public bool $showCreate = false;
    public bool $isUpdate = false;
    public bool $withTrash = false;

//    public function mount(){
//        middleware(['permission:category show'])->only('index' , 'show');
//        $this->middleware(['permission:category edit'])->only('edit' , 'update');
//        $this->middleware(['permission:category create'])->only('create' , 'store');
//        $this->middleware(['permission:category delete'])->only('destroy');
//    }

    public function render()
    {
        $this->users = \App\Models\User::OwenUser()->pluck('name', 'id');
        $this->user_id = auth()->id();
        $this->jobs = \App\Models\Job::pluck('name', 'id');
        $this->date = today()->format('Y-m-d');
        if ($this->withTrash) {
            $meetings = \App\Models\Meeting::whereBetween('date',[$this->filter_from,$this->filter_to])->withTrashed(); // meetings paginate
        } else {
            $meetings = \App\Models\Meeting::whereBetween('date',[$this->filter_from,$this->filter_to]); // meetings paginate
        }
        $meetings = $meetings->orderBy('date')->paginate(10);
        return view('livewire.admin.meeting', compact('meetings'));
    }

    public function mount()
    {
        $this->filter_from = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->filter_to = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function export()
    {
        if ($this->withTrash) {
            $meetings = \App\Models\Meeting::with(['user','position','team','branch','job'])->whereBetween('date',[$this->filter_from,$this->filter_to])->withTrashed(); // meetings paginate
        } else {
            $meetings = \App\Models\Meeting::with(['user','position','team','branch'])->whereBetween('date',[$this->filter_from,$this->filter_to]); // meetings paginate
        }
        $meetings = $meetings->orderBy('date')->get();
        $fileName = "اجتماعات من " .$this->filter_from." الي ".$this->filter_to;
        return Excel::download(new MeetingsExport($meetings), $fileName.'.xlsx');
    }


    public function save()
    {
        $this->valid();
        $user = \App\Models\User::find($this->user_id);
        $meeting = \App\Models\Meeting::create([
            'title' => $this->title,
            'date' => $this->date,
            'count' => $this->count,
            'comment' => $this->comment,
            'status' => $this->status,
            'user_id' => $this->user_id,
            'add_by' => auth()->id(),
            'position_id' => $user->position_id,
            'team_id' => $user->team_id,
            'branch_id' => $user->branch_id,
            'job_id' => $user->job_id,
        ]);
        if ($meeting) {
            $this->resetInput();
            $this->dispatch('close');
            $this->dispatch('notify');
        }
    }


    //get one meeting
    public function show($id)
    {
        $this->isUpdate = true;
        $meeting = $this->withTrash ? \App\Models\Meeting::withTrashed()->find($id) : \App\Models\Meeting::find($id);
        $this->id = $meeting->id;
        $this->title = $meeting->title;
        $this->comment = $meeting->comment;
        $this->date = $meeting->date;
        $this->count = $meeting->count;
        $this->status = $meeting->status;
        $this->user_id = $meeting->user_id;
        $this->job_id = $meeting->job_id;
    }

    public function update()
    {
        $this->valid();
        $user = \App\Models\User::find($this->user_id);
        $barnch = \App\Models\Meeting::find($this->id);
        if ($barnch) {
            $barnch->update([
                'title' => $this->title,
                'date' => $this->date,
                'count' => $this->count,
                'comment' => $this->comment,
                'status' => $this->status,
                'user_id' => $this->user_id,
                'add_by' => auth()->id(),
                'position_id' => $user->position_id,
                'team_id' => $user->team_id,
                'branch_id' => $user->branch_id,
            ]);
        }
        $this->resetInput();
        $this->dispatch('close');
        $this->dispatch('notify');
    }

    public function delete()
    {
        $meeting = $this->withTrash ? \App\Models\Meeting::withTrashed()->find($this->id) : \App\Models\Meeting::find($this->id);

        if ($this->deleted_at) {
            $meeting->forceDelete();
        } else {
            $meeting->delete();
        }
        $this->dispatch('close');
        $this->dispatch('notify');
        $this->resetInput();
    }


    public function resetInput()
    {
        $this->reset(['title','date','count','comment','status','user_id','add_by','position_id','team_id','branch_id','job_id']);
//        $this->reset();
    }

    private function valid()
    {
        $validated = $this->validate([
            'title' => 'required|min:3',
            'date' => 'required|date',
            'count' => 'required|numeric|min:1',
            'status' => 'required|in:0,1',
            'user_id' => 'required|' . Rule::in(\App\Models\User::all()->pluck('id')),
        ]);
    }
}
