<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class Role extends Component
{
    use WithPagination;
    public $id;
    public string $name;
    public $deleted_at;
    public $permission=[];
    public bool $showCreate=false;
    public bool $isUpdate=false;
    public bool $withTrash=false;


    public function render()
    {

            $roles = \Spatie\Permission\Models\Role::with('permissions')->paginate(10); // role paginate
//        dd($roles);
        return view('livewire.admin.role',compact('roles'));
    }

    public function save(){
        $this->valid();
        $role = \Spatie\Permission\Models\Role::create([
            'name'=>$this->name,
        ]);
        $role->syncPermissions($this->permission);
        if ($role){
            $this->resetInput();
            $this->dispatch('close');
            $this->dispatch('notify');
        }
    }


    //get one role
    public function show($id){
        $this->isUpdate=true;
        $role = \Spatie\Permission\Models\Role::find($id);
        $this->permission = $role->permissions->pluck('name');
        $this->id = $role->id;
        $this->name = $role->name;
        $this->deleted_at = $role->deleted_at;
    }

    public function update(){
        $this->valid();
        $role = \Spatie\Permission\Models\Role::find($this->id);
        if ($role){
            $role->update([
                'name'=>$this->name,
            ]);
            $role->syncPermissions($this->permission);
        }
        $this->resetInput();
        $this->dispatch('close');
        $this->dispatch('notify');
    }

    public function delete(){
        $role = \Spatie\Permission\Models\Role::find($this->id);

        if($this->deleted_at)
        {
            $role->forceDelete();
        }else {
            $role->delete();
        }
        $this->dispatch('close');
        $this->dispatch('notify');
        $this->resetInput();
    }


    public function resetInput(){
        $this->reset(['name','id','showCreate','isUpdate','deleted_at','permission']);
    }
    private function valid(){
        $validated = $this->validate([
            'name' => 'required|min:3',
        ]);
    }
}
