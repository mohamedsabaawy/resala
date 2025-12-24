<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BranchSeeder::class,
            PositionSeeder::class,
        ]);

        $permission = [
            'role show',
            'role edit',
            'role create',
            'role delete',
            'activity show',
            'activity edit',
            'activity create',
            'activity delete',
            'branch show',
            'branch edit',
            'branch create',
            'branch delete',
            'category show',
            'category edit',
            'category create',
            'category delete',
            'degree show',
            'degree edit',
            'degree create',
            'degree delete',
            'event show',
            'event edit',
            'event create',
            'event delete',
            'job show',
            'job edit',
            'job create',
            'job delete',
            'link show',
            'link edit',
            'link create',
            'link delete',
            'maritalStatus show',
            'maritalStatus edit',
            'maritalStatus create',
            'maritalStatus delete',
            'nationality show',
            'nationality edit',
            'nationality create',
            'nationality delete',
            'position show',
            'position edit',
            'position create',
            'position delete',
            'qualification show',
            'qualification edit',
            'qualification create',
            'qualification delete',
            'status show',
            'status edit',
            'status create',
            'status delete',
            'team show',
            'team edit',
            'team create',
            'team delete',
            'user show',
            'user edit',
            'user create',
            'user delete',
            'user export',
            'approval show',
            'approval edit',
            'approval create',
            'approval delete',
            'main menu show',
            'user menu show',
            'role menu show',
            'meeting show',
            'meeting edit',
            'meeting create',
            'meeting delete',

        ];

        foreach ($permission as $item) {
            Permission::updateOrCreate([
                'name' => $item,
            ]);
        }

        Role::create(['name' => 'مدير','guard_name'=>'web','branch_id'=>1]);
        Role::create(['name' => 'مشرف','guard_name'=>'web','branch_id'=>1]);
        Role::create(['name' => 'متطوع','guard_name'=>'web','branch_id'=>1]);

        $role = Role::find(1)->syncPermissions($permission);

        $users = User::where('role', 'admin')->get();
        foreach ($users as $user) {
            $user->assignRole('مدير');
        }

        $users = User::where('role', 'supervisor')->get();
        foreach ($users as $user) {
            $user->assignRole('مشرف');
        }

        $users = User::where('role', 'user')->get();
        foreach ($users as $user) {
            $user->assignRole('متطوع');
        }

        $superAdmin = User::updateOrCreate([
            'code'=>'10',
        ],[
            'name'=>'admin',
            'email'=>'admin@admin.com',            
            'password'=>bcrypt(10),
            'role'=>'superAdmin',
            'branch_id' => 1,

        ]);

        $superAdmin->assignRole('مدير');

        //        User::create([
        //           'name'=>"مدير",
        //           'phone'=>"0111",
        //           'code'=>"7001",
        //           'position_id'=>1,
        //           'branch_id'=>1,
        //           'team_id'=>1,
        //           'role'=>'admin',
        //           'join_date'=>today(),
        //        ]);
    }
}
