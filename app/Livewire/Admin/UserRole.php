<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class UserRole extends Component
{
    use WithPagination;
    public $id;
    public string $name;
    public $roles;
    public $type;
    public $permission=[];
    public $selectedTeam=[];
    public $deleted_at;
    public bool $showCreate=false;
    public bool $isUpdate=false;
    public bool $withTrash=false;


    public function render()
    {
        $allRoles = \Spatie\Permission\Models\Role::select('name')->get();
        $allTeams = \App\Models\Team::select('id','name')->get();
        $this->selectedTeam = Auth::user()->teams->pluck('id');
        if ($this->withTrash){
            $users = \App\Models\User::withTrashed()->paginate(10); // users paginate
        }else{
            $users = \App\Models\User::paginate(10); // users paginate
        }
        return view('livewire.admin.userRole',compact(['users','allRoles','allTeams']));
    }

    public function save(){
        $this->valid();
        $user = \App\Models\User::create([
            'name'=>$this->name,
            'role'=>$this->type  ? 'admin' : 'user',
        ]);
        $user->teams()->sync($this->selectedTeam);
        $user->syncRoles($this->roles);
        $user->syncPermissions($this->permission);
        if ($user){
            $this->resetInput();
            $this->dispatch('close');
            $this->dispatch('notify');
        }
    }


    //get one user
    public function show($id){
        $this->isUpdate=true;
        $user = $this->withTrash ? \App\Models\User::withTrashed()->find($id) : \App\Models\User::find($id);
        $this->roles = $user->getRoleNames()->first();
        $this->permission = $user->permissions->pluck('name');
        $this->selectedTeam = $user->teams->pluck('id');
        $this->id = $user->id;
        $this->name = $user->name;
        $this->type = $user->role == 'admin' ? true : false;
        $this->deleted_at = $user->deleted_at;
    }

    public function update(){
        $this->valid();
        $user = \App\Models\User::find($this->id);
        if ($user){
            $user->update([
                'name'=>$this->name,
                'role'=>$this->type  ? 'admin' : 'user',
            ]);
            $user->syncRoles($this->roles);
            $user->syncPermissions($this->permission);
            $user->teams()->sync($this->selectedTeam);
        }
        $this->resetInput();
        $this->dispatch('close');
        $this->dispatch('notify');
    }

    public function delete(){
        $user = $this->withTrash ? \App\Models\User::withTrashed()->find($this->id) : \App\Models\User::find($this->id);

        if($this->deleted_at)
        {
            $user->forceDelete();
        }else {
            $user->delete();
        }
        $this->dispatch('close');
        $this->dispatch('notify');
        $this->resetInput();
    }


    public function resetInput(){
        $this->reset(['name','id','showCreate','isUpdate','deleted_at','type','permission','roles','selectedTeam']);
    }
    private function valid(){
        $validated = $this->validate([
            'name' => 'required|min:3',
        ]);
    }
}
