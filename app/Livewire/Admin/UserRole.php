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
    public $need_approve;
    public $permission=[];
    public $selectedTeam=[];
    public $deleted_at;
    public bool $showCreate=false;
    public bool $isUpdate=false;
    public bool $withTrash=false;
    public $searchCode;
    public $searchName;


    public function render()
    {
        $allRoles = \App\Models\Role::select('name')->get();
        $allTeams = \App\Models\Team::select('id','name')->get();
        if ($this->withTrash){
            $users = \App\Models\User::OwenUser()->with(['roles'])->withTrashed(); // users paginate
        }else{
            $users = \App\Models\User::OwenUser()->with(['roles']); // users paginate
        }
        $this->customFilter($users);
        $users = $users->paginate(10);
        return view('livewire.admin.userRole',compact(['users','allRoles','allTeams']));
    }

    public function save(){
        $this->valid();
        $user = \App\Models\User::OwenUser()->create([
            'name'=>$this->name,
            'role'=>$this->type ,
            'need_approve'=>$this->need_approve  ? 1 : 0,
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
        $user =  \App\Models\User::OwenUser()->with('teams')->find($id);
        $this->roles = $user->getRoleNames()->first();
        $this->permission = $user->permissions->pluck('name');
        $this->selectedTeam = $user->teams->pluck('id');
        $this->id = $user->id;
        $this->name = $user->name;
        $this->type = $user->role;
        $this->need_approve = $user->need_approve== '1' ? true : false;
        $this->deleted_at = $user->deleted_at;
        $this->isUpdate=true;
//        dd($this->selectedTeam);
    }

    public function update(){
//        dd($this->need_approve);
        $this->valid();
        $user = \App\Models\User::OwenUser()->find($this->id);
        if ($user){
            $user->update([
                'name'=>$this->name,
                'role'=>$this->type ,
                'need_approve'=>$this->need_approve  ? '1' : '0',
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
        $user = $this->withTrash ? \App\Models\User::OwenUser()->withTrashed()->find($this->id) : \App\Models\User::OwenUser()->find($this->id);

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
        $this->reset(['name','id','showCreate','isUpdate','deleted_at','type','permission','roles','selectedTeam','need_approve']);
    }
    private function valid(){
        $validated = $this->validate([
            'name' => 'required|min:3',
        ]);
    }

    protected function customFilter($users)
    {
        if (strlen($this->searchCode) > 0) {
            $users = $users->Where('code', 'like', "%$this->searchCode%");
        }
        if (strlen($this->searchName) > 0) {
            $users = $users->Where('name', 'like', "%$this->searchName%");
        }
        return $users;
    }
}
