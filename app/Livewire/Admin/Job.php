<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;

class Job extends Component
{
    use WithPagination;
    public $id , $manager_id=null,$managers;
    public string $name;
    public $deleted_at;
    public bool $showCreate=false;
    public bool $isUpdate=false;
    public bool $withTrash=false;


    public function render()
    {
        if ($this->withTrash){
            $jobs = \App\Models\Job::with('manager')->withTrashed()->paginate(10); // jobs paginate
        }else{
            $jobs = \App\Models\Job::with('manager')->paginate(10); // jobs paginate
        }
        return view('livewire.admin.job',compact('jobs'));
    }
    public function mount(){
        $this->managers = \App\Models\User::all();
    }

    public function save(){
        $this->valid();
        $job = \App\Models\Job::create([
            'name'=>$this->name,
            'manager_id'=>strlen($this->manager_id)>0 ? $this->manager_id: null,
        ]);
        if ($job){
            $this->resetInput();
            $this->dispatch('close');
            $this->dispatch('notify');
        }
    }


    //get one job
    public function show($id){
        $this->isUpdate=true;
        $job = $this->withTrash ? \App\Models\Job::withTrashed()->find($id) : \App\Models\Job::find($id);
        $this->id = $job->id;
        $this->name = $job->name;
        $this->deleted_at = $job->deleted_at;
        $this->manager_id = $job->manager_id;
    }

    public function update(){
//        dd(strlen($this->manager_id)>0 ?? null);
        $this->valid();
        $job = \App\Models\Job::find($this->id);
        if ($job){
            $job->update([
                'name'=>$this->name,
                'manager_id'=>strlen($this->manager_id)>0 ? $this->manager_id: null,
            ]);
        }
        $this->resetInput();
        $this->dispatch('close');
        $this->dispatch('notify');
    }

    public function delete(){
        $job = $this->withTrash ? \App\Models\Job::withTrashed()->find($this->id) : \App\Models\Job::find($this->id);

        if($this->deleted_at)
        {
            $job->forceDelete();
        }else {
            $job->delete();
        }
        $this->dispatch('close');
        $this->dispatch('notify');
        $this->resetInput();
    }


    public function resetInput(){
        $this->reset(['name','id','showCreate','isUpdate','deleted_at','manager_id']);
    }
    private function valid(){
        $validated = $this->validate([
            'name' => 'required|min:3',
        ]);
    }
}
