<?php

namespace App\Livewire\Admin;

use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Team extends Component
{
    use WithPagination;
    public $id, $name, $manager_id=null,$count,$managers;
    public $showCreate=false;
    public $isUpdate=false;
    public function render()
    {
        $teams = \App\Models\Team::with('manager')->paginate(10); // team paginate
        return view('livewire.admin.team',compact('teams'));
    }

    public function mount(){
        $this->managers = \App\Models\User::all();
    }

    public function save(){
        $this->valid();
        $branch = \App\Models\Team::create([
            'name'=>$this->name,
            'count'=>$this->count,
            'manager_id'=>strlen($this->manager_id)>0 ?? null,
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
        $team = \App\Models\Team::find($id);
        $this->id = $team->id;
        $this->name = $team->name;
        $this->count = $team->count;
        $this->manager_id = $team->manager_id;
    }

    public function update(){
        $this->valid();
        $team = \App\Models\Team::find($this->id);
        if ($team){
            $team->update([
                'name'=>$this->name,
                'count'=>$this->count,
                'manager_id'=>strlen($this->manager_id)>0 ?? null,
            ]);
        }
        $this->dispatch('close');
        $this->dispatch('notify');
    }

    public function delete(){
        $branch = \App\Models\Team::find($this->id);
        $branch->delete();
        $this->dispatch('close');
        $this->dispatch('notify');
    }

    public function resetInput(){
        $this->id = "";
        $this->name = "";
        $this->manager_id = "";
        $this->count = "";
    }
    private function valid(){
        $validated = $this->validate([
            'name' => 'required|min:3',
            'count' => 'required|numeric|min:1',
            'manager_id' => ['nullable',Rule::in($this->managers->pluck('id'))],
        ]);
    }
}
