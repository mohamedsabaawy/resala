<?php

namespace App\Livewire;

use App\Exports\UsersExport;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class User extends Component
{
    use WithPagination, WithFileUploads;

    public $id, $name, $phone, $card_id, $photo,$newPhoto, $password = 123456, $join_date, $comment, $team_id, $position_id, $status="active", $branch_id,$role="user";
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
            'phone' => $this->phone,
            'card_id' => $this->card_id,
            'photo' => $this->photo->store('users','public'),
            'password' => bcrypt($this->password),
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
    }

    public function update()
    {
        $this->valid();
        $barnch = \App\Models\User::find($this->id);
        if ($barnch) {
            $barnch->update([
                'name' => $this->name,
                'phone' => $this->phone,
                'card_id' => $this->card_id,
                'photo' => $this->newPhoto ? $this->newPhoto->store('users','public'): $this->photo,
                'password' => bcrypt(123456),
                'join_date' => $this->join_date,
                'comment' => $this->comment,
                'team_id' => $this->team_id,
                'position_id' => $this->position_id,
                'branch_id' => $this->branch_id,
                'status' => $this->status,
            ]);

            if(isset($this->newPhoto)){
                Storage::disk('public')->delete($this->photo);
            }
        }
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
            'photo' => "required",
//            'password'=>"required",
            'join_date' => "required",
            'comment' => "required",
            'team_id' => "required",
            'position_id' => "required",
            'branch_id' => "required",
            'status' => "required",
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
