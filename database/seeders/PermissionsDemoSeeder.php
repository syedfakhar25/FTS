<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'DepCreate']);
        Permission::create(['name' => 'DepRead']);
        Permission::create(['name' => 'DepEdit']);
        Permission::create(['name' => 'DepDelete']);

        Permission::create(['name' => 'UserCreate']);
        Permission::create(['name' => 'UserRead']);
        Permission::create(['name' => 'UserEdit']);
        Permission::create(['name' => 'UserDelete']);

        Permission::create(['name' => 'FileCreate']);
        Permission::create(['name' => 'FileRead']);
        Permission::create(['name' => 'FileEdit']);
        Permission::create(['name' => 'FileDelete']);


        // create roles and assign existing permissions

        $role1 = Role::create(['name' => 'Administrator']);
        $role2 = Role::create(['name' => 'DepartmentAdmin']);
        $role3 = Role::create(['name' => 'DepartmentDispatchOfficer']);

        //Assign Permissions
        $role1->givePermissionTo('DepCreate');
        $role1->givePermissionTo('DepRead');
        $role1->givePermissionTo('DepEdit');
        $role1->givePermissionTo('DepDelete');

        $role1->givePermissionTo('UserCreate');
        $role1->givePermissionTo('UserRead');
        $role1->givePermissionTo('UserEdit');
        $role1->givePermissionTo('UserDelete');

        $role1->givePermissionTo('FileRead');


        $role2->givePermissionTo('FileCreate');
        $role2->givePermissionTo('FileRead');
        $role2->givePermissionTo('FileEdit');
        $role2->givePermissionTo('FileDelete');


        $role3->givePermissionTo('FileCreate');
        //$role3->givePermissionTo('FileRead');
        //$role3->givePermissionTo('FileEdit');


        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        $user = \App\Models\User::factory()->create([
            'name' => 'ExAdministrator',
            'mobile_number' => '923000000001',
            'password' => Hash::make('123456'),
        ]);
        $user->assignRole($role1);

        $user = \App\Models\User::factory()->create([
            'name' => 'ExDepAdmin',
            'mobile_number' => '923000000021',
            'department_id'=>1,
            'password' => Hash::make('123456'),
        ]);
        $user->assignRole($role2);
        $user = \App\Models\User::factory()->create([
            'name' => 'ExDepDispatcher',
            'mobile_number' => '923000000022',
            'department_id'=>1,
            'password' => Hash::make('123456'),
        ]);
        $user->assignRole($role3);

        $user = \App\Models\User::factory()->create([
            'name' => 'ExDepAdminHD',
            'mobile_number' => '923000000031',
            'department_id'=>2,
            'password' => Hash::make('123456'),
        ]);
        $user->assignRole($role2);
        $user = \App\Models\User::factory()->create([
            'name' => 'ExDepDispatcherHD',
            'mobile_number' => '923000000032',
            'department_id'=>2,
            'password' => Hash::make('123456'),
        ]);
        $user->assignRole($role3);

        $user = \App\Models\User::factory()->create([
            'name' => 'ExDepAdminPMS',
            'mobile_number' => '923000000041',
            'department_id'=>3,
            'password' => Hash::make('123456'),
        ]);
        $user->assignRole($role2);

        $user = \App\Models\User::factory()->create([
            'name' => 'ExDepDispatcherPMS',
            'mobile_number' => '923000000042',
            'department_id'=>3,
            'password' => Hash::make('123456'),
        ]);
        $user->assignRole($role3);

        Department::factory()->create([
            'title'=>'Chief Secretary Office',
            'short_code'=>'CSO'
        ]);
        Department::factory()->create([
            'title'=>'Home Department',
            'short_code'=>'HD'
        ]);
        Department::factory()->create([
            'title'=>'Prime Minister Secretariat',
            'short_code'=>'PMS'
        ]);
        Department::factory()->create([
            'title'=>'Services Department',
            'short_code'=>'SD'
        ]);
    }
}
