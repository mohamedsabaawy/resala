<?php

namespace App\Livewire;

use App\Exports\UsersExport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class User extends Component
{
    use WithPagination, WithFileUploads;

    public $id, $name, $code , $phone, $card_id, $photo,$newPhoto, $password,$newPassword , $join_date, $comment, $team_id, $position_id, $status="active", $branch_id,$role="user";
    public $showCreate = false;
    public $isUpdate = false;
// activity
    public function render()
    {
        $teams = \App\Models\Team::select('id', 'name')->get();
        $positions = \App\Models\Position::select('id', 'name')->get();
        $branches = \App\Models\Branch::select('id', 'name')->get();
        $checkTypes = \App\Models\CheckType::select('id', 'name')->get();
        $users = \App\Models\User::with(['branch','team'])->paginate(10); // branches paginate
        return view('livewire.user', compact(['users', 'teams', 'positions', 'branches', 'checkTypes']));
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }


    public function save()
    {
        $this->valid();
        $branch = \App\Models\User::create([
            'name' => $this->name,
            'code' => $this->code,
            'phone' => $this->phone,
            'card_id' => $this->card_id,
            'photo' => $this->photo->store('users','public'),
            'password' => bcrypt(123456),
            'join_date' => $this->join_date,
            'comment' => $this->comment,
            'team_id' => $this->team_id,
            'position_id' => $this->position_id,
            'branch_id' => $this->branch_id,
            'status' => $this->status,
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
        $user = \App\Models\User::find($id);
        $this->id = $user->id;
        $this->name = $user->name;
        $this->phone = $user->phone;
        $this->card_id = $user->card_id;
        $this->photo = $user->photo;
        $this->join_date = $user->join_date;
        $this->comment = $user->comment;
        $this->team_id = $user->team_id;
        $this->position_id = $user->position_id;
        $this->branch_id = $user->branch_id;
        $this->status = $user->status;
        $this->code = $user->code;
//        $this->password = $user->password;
    }

    public function update()
    {
        $this->valid();
        $user = \App\Models\User::find($this->id);
        $password = $user->password;
        if ($user) {
            $user->update([
                'name' => $this->name,
                'code' => $this->code,
                'phone' => $this->phone,
                'card_id' => $this->card_id,
                'photo' => $this->newPhoto ? $this->newPhoto->store('users','public'): $this->photo,
                'password' => $this->newPassword ? bcrypt($this->newPassword):$password,
                'join_date' => $this->join_date,
                'comment' => $this->comment,
                'team_id' => $this->team_id,
                'position_id' => $this->position_id,
                'branch_id' => $this->branch_id,
                'status' => $this->status,
            ]);

            if(isset($this->newPhoto) and isset($this->photo)){
                Storage::disk('public')->delete($this->photo);
            }
        }
        $this->resetInput();
        $this->dispatch('close');
        $this->dispatch('notify');
    }

    public function delete()
    {
        $branch = \App\Models\User::find($this->id);
        $branch->delete();
        Storage::disk('public')->delete($this->photo);
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
            'name' => "required",
            'phone' => "required",
            'card_id' => "required",
//            'photo' => "required",
            'password'=>$this->isUpdate ? "" : "required",
            'join_date' => "required",
            'comment' => "required",
            'team_id' => "required",
            'position_id' => "required",
            'branch_id' => "required",
            'status' => "required",
            'code' => ["required",
                $this->isUpdate ? Rule::unique('users')->ignore($this->id) : Rule::unique('users')
                ],
        ]
//            ,
//            [
//            'name.required' => 'برجاء ادخل اسم الفريق',
//            'count.required' => 'برجاء ادخل عدد افراد الفريق',
//            'count.min' => 'برجاء ادخال رقم اكبر من او يساوي :min',
//            'phone.required' => 'هذا الحقل مطلوب ',
//        ]
        );
    }
}
