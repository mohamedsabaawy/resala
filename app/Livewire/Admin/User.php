<?php

namespace App\Livewire\Admin;

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

    public $id, $name, $code, $phone, $national_id, $photo, $newPhoto, $password, $newPassword, $oldPassword, $join_date, $comment, $team_id, $position_id, $status = "active", $branch_id, $role = "user", $category_id, $degree_id, $job_id, $marital_status_id, $qualification_id, $nationality_id, $status_id, $gender, $email, $address, $birth_date, $filter_from, $filter_to;
    public $roles, $searchName, $searchCode, $job;
    public $showCreate = false;
    public $isUpdate = false;
    public $withTrash = false;

// activity
    public function render()
    {

        $teams = \App\Models\Team::select('id', 'name')->get();
        $jobs = \App\Models\Job::select('id', 'name')->get();
        $categories = \App\Models\Category::select('id', 'name')->get();
        $statuses = \App\Models\Status::select('id', 'name')->get();
        $qualifications = \App\Models\Qualification::select('id', 'name')->get();
        $nationalities = \App\Models\Nationality::select('id', 'name')->get();
        $maritalStatuses = \App\Models\MaritalStatus::select('id', 'name')->get();
        $degrees = \App\Models\Degree::select('id', 'name')->get();
        $positions = \App\Models\Position::select('id', 'name')->get();
//        $branches = \App\Models\Branch::select('id', 'name')->get();
        $checkTypes = \App\Models\CheckType::select('name')->get();
        $users = $this->withTrash ? \App\Models\User::OwenUser()->withTrashed()->with(['branch', 'team']) : \App\Models\User::OwenUser()->with(['branch', 'team']);
        $this->customFilter($users);
        $users = $users->orderBy('code')->paginate(10);
        $allRoles = \App\Models\Role::select('name')->get();
        return view('livewire.admin.user', compact([
            'users', 'teams', 'jobs', 'categories', 'statuses', 'qualifications', 'nationalities', 'maritalStatuses', 'degrees', 'positions', 'checkTypes', 'allRoles'
        ]));
    }

    public function export()
    {
        $filter_from = $this->filter_from ?? date_format(today(), "Y-m-01");
        $filter_to = $this->filter_to ?? date_format(today(), "Y-m-t");
        $users = \App\Models\User::OwenUser()->with(['team', 'position', 'activities' => function ($query) use ($filter_from) {
            $query->where([
                ['activity_date', '>=', $filter_from],
                ['approval', 1]
            ]);
        }])->get()->sortBy('team_id');
        $filename = 'مشاركات من '.$filter_from.' الي '.$filter_to;
        return Excel::download(new UsersExport($users, $filter_from, $filter_to), $filename.'.xlsx');
    }


    public function save()
    {
        $this->valid();
        $user = \App\Models\User::create([
            'name' => $this->name,
            'code' => $this->code,
            'phone' => $this->phone,
            'national_id' => $this->national_id,
            'photo' => $this->newPhoto ? $this->newPhoto->store('users', 'public') : $this->photo,
            'password' => $this->password,
            'join_date' => $this->join_date,
            'comment' => $this->comment,
            'team_id' => $this->team_id,
            'position_id' => $this->position_id,
            'branch_id' => session('branch_id'),
            'status_id' => $this->status_id,
            'job_id' => $this->job_id,
            'category_id' => $this->category_id,
            'qualification_id' => $this->qualification_id,
            'nationality_id' => $this->nationality_id,
            'marital_status_id' => $this->marital_status_id,
            'degree_id' => $this->degree_id,
            'gender' => $this->gender,
            'email' => $this->email,
            'address' => $this->address,
            'birth_date' => $this->birth_date,

        ]);
        $user->syncRoles($this->roles);
        if ($user) {
            $this->resetInput();
            $this->dispatch('close');
            $this->dispatch('notify');
        }
    }


    //get one branch
    public function show($id)
    {
        $this->isUpdate = true;
        $user = \App\Models\User::with('roles')->find($id);
        $this->roles = $user->getRoleNames()->first();
        $this->id = $user->id;
        $this->name = $user->name;
        $this->phone = $user->phone;
        $this->national_id = $user->national_id;
        $this->photo = $user->photo;
        $this->join_date = $user->join_date;
        $this->comment = $user->comment;
        $this->team_id = $user->team_id;
        $this->position_id = $user->position_id;
        $this->branch_id = $user->branch_id;
        $this->code = $user->code;
        $this->category_id = $user->category_id;
        $this->status_id = $user->status_id;
        $this->qualification_id = $user->qualification_id;
        $this->nationality_id = $user->nationality_id;
        $this->degree_id = $user->degree_id;
        $this->gender = $user->gender;
        $this->email = $user->email;
        $this->address = $user->address;
        $this->birth_date = $user->birth_date;
        $this->role = $user->role;
        $this->oldPassword = $user->password;
        $this->job_id = $user->job_id;
        $this->marital_status_id = $user->marital_status_id;
//        dd($this->role);
        //$gender,$email,$address,$birth_date
        //'jobs','categories','statuses','qualifications','nationalities','maritalStatuses','degrees'
//        $this->password = $user->password;
    }

    public function update()
    {
        $this->valid();
        $user = \App\Models\User::find($this->id);
//        dd($this->roles);
        $user->syncRoles($this->roles);
        $password = $user->password;
        if ($user) {
            $user->update([
                'name' => $this->name,
                'code' => $this->code,
                'phone' => $this->phone,
                'national_id' => $this->national_id,
                'photo' => $this->newPhoto ? $this->newPhoto->store('users', 'public') : $this->photo,
                'password' => $this->newPassword ? bcrypt($this->newPassword) : $this->oldPassword,
                'join_date' => $this->join_date,
                'comment' => $this->comment,
                'team_id' => $this->team_id,
                'position_id' => $this->position_id,
                'branch_id'=>session('branch_id'),
                'status_id' => $this->status_id,
                'job_id' => $this->job_id,
                'category_id' => $this->category_id,
                'qualification_id' => $this->qualification_id,
                'nationality_id' => $this->nationality_id,
                'marital_status_id' => $this->marital_status_id,
                'degree_id' => $this->degree_id,
                'gender' => $this->gender,
                'email' => $this->email,
                'address' => $this->address,
                'birth_date' => $this->birth_date,
                'role' => $this->role,
            ]);

            if (isset($this->newPhoto) and isset($this->photo)) {
                Storage::disk('public')->delete($this->photo);
            }
        }
        $this->skipRender();
        $this->resetInput();
        $this->dispatch('close');
        $this->dispatch('notify');
    }

    public function delete()
    {
        $user = \App\Models\User::find($this->id);
        $user->delete();
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
                'phone' => "required|numeric",
                'national_id' => "required|numeric",
//            'photo' => "required",
                'password' => $this->isUpdate ? "" : "required",
                'join_date' => "required|date:'dd-mm-yy'",
                'birth_date' => "required|date:'dd-mm-yy'",
                'comment' => "required",
                'team_id' => "required",
                'job_id' => "required",
                'position_id' => "required",
//                'branch_id' => "required",
                'status' => "required",
                'code' => ["required",
                    Rule::unique('users')->where(function ($query) {
                        return $query->where('branch_id', auth()->user()->branch_id);
                    })->ignore($this->id)
//                    $this->isUpdate ? Rule::unique('users')->ignore($this->id) : Rule::unique('users')
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

    protected function customFilter($users)
    {
        if (strlen($this->searchCode) > 0) {
            $users = $users->Where('code', 'like', "%$this->searchCode%");
        }
        if (strlen($this->searchName) > 0) {
            $users = $users->Where('name', 'like', "%$this->searchName%");
        }
        if ($this->job)
            $users = $users->where('job_id', $this->job);
        return $users;
    }

}
