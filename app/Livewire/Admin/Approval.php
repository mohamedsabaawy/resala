<?php

namespace App\Livewire\Admin;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\Activity;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;


class Approval extends Component
{
    use WithPagination;

    //default

    public $id, $name, $manager_id = null, $count, $managers, $filter =[0],$dateFrom,$dateTo;//filter
    public $showCreate = false;
    public $isUpdate = false;

    public function render()
    {
        dd(651656);
        $activities = Activity::with(['user', 'event'])
        ->whereHas('user',function($q){
            return $q->where('branch_id',session('branch_id'));
        })
        ->whereIn('approval',$this->filter)->orderBy('activity_date'); // activity paginate
        if (!empty($this->dateFrom))
            $activities = $activities->where('activity_date','>=',$this->dateFrom);
        if (!empty($this->dateTo))
            $activities = $activities->where('activity_date','<=',$this->dateTo);
        // if (!in_array(auth()->user()->role, ['admin','superAdmin'])){} {
        //     $activities = $activities->where('manager_id', auth()->id());
        // }
        $activities = $activities->paginate(10);
        return view('livewire.admin.approval', compact('activities'));
    }

    public function mount()
    {
        $this->dateFrom = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->dateTo=Carbon::now()->endOfMonth()->format('Y-m-d');
        // $this->managers = \App\Models\User::all();
    }

    public function save()
    {
        $this->valid();
        $branch = Activity::create([
            'name' => $this->name,
            'count' => $this->count,
            'manager_id' => strlen($this->manager_id) > 0 ?? null,
        ]);
        if ($branch) {
            $this->resetInput();
            $this->dispatch('close');
            $this->dispatch('notify');
        }
    }


    //get one branch
    public function show($id)
    {
        $this->isUpdate = true;
        $activity = Activity::find($id);
        $this->id = $activity->id;
        $this->name = $activity->name;
        $this->count = $activity->count;
        $this->manager_id = $activity->manager_id;
    }

    public function update()
    {
        $this->valid();
        $activity = Activity::find($this->id);
        if ($activity) {
            $activity->update([
                'name' => $this->name,
                'count' => $this->count,
                'manager_id' => strlen($this->manager_id) > 0 ?? null,
            ]);
        }
        $this->dispatch('close');
        $this->dispatch('notify');
    }

    public function delete()
    {
        $branch = Activity::find($this->id);
        $branch->delete();
        $this->dispatch('close');
        $this->dispatch('notify');
    }

    public function approve($id)
    {
        $activity = Activity::find($id)->update([
            'approval' => 1
        ]);
    }

    public function resetInput()
    {
        $this->id = "";
        $this->name = "";
        $this->manager_id = "";
        $this->count = "";
    }

    private function valid()
    {
        $validated = $this->validate([
            'name' => 'required|min:3',
            'count' => 'required|numeric|min:1',
            'manager_id' => ['nullable', Rule::in($this->managers->pluck('id'))],
        ]);
    }

    public function startFilter()
    {
        $this->filter;
    }
}
