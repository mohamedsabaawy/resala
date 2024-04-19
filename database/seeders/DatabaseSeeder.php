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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
//        $this->call([
//           PositionSeeder::class,
//        ]);

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
        ];

        foreach ($permission as $item){
            Permission::create([
                'name' => $item
            ]);
        }

        Role::create(['name'=>'مدير']);
        Role::create(['name'=>'مشرف']);
        Role::create(['name'=>'متطوع']);

        $role = Role::find(1)->syncPermissions($permission);

        $users = User::where('role','admin')->get();
        foreach ($users as $user){
            $user->assignRole('مدير');
        }

        $users = User::where('role','supervisor')->get();
        foreach ($users as $user){
            $user->assignRole('مشرف');
        }

        $users = User::where('role','user')->get();
        foreach ($users as $user){
            $user->assignRole('متطوع');
        }

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
