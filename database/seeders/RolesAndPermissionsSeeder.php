<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'View Dashboard']);

        Permission::create(['name' => 'Add Users']);
        Permission::create(['name' => 'Delete Users']);
        Permission::create(['name' => 'View Users']);
        Permission::create(['name' => 'Edit Users']);

        Permission::create(['name' => 'Add Roles']);
        Permission::create(['name' => 'Delete Roles']);
        Permission::create(['name' => 'View Roles']);
        Permission::create(['name' => 'Edit Roles']);

        Permission::create(['name' => 'Add Borrowers']);
        Permission::create(['name' => 'Delete Borrowers']);
        Permission::create(['name' => 'View Borrowers']);
        Permission::create(['name' => 'Edit Borrowers']);

        Permission::create(['name' => 'Add Loans']);
        Permission::create(['name' => 'Delete Loans']);
        Permission::create(['name' => 'View Loans']);
        Permission::create(['name' => 'Edit Loans']);

        Permission::create(['name' => 'Add Payments']);
        Permission::create(['name' => 'Delete Payments']);
        Permission::create(['name' => 'View Payments']);
        Permission::create(['name' => 'Edit Payments']);

        Permission::create(['name' => 'Add Branches']);
        Permission::create(['name' => 'Delete Branches']);
        Permission::create(['name' => 'View Branches']);
        Permission::create(['name' => 'Edit Branches']);

        Permission::create(['name' => 'Add Expenses']);
        Permission::create(['name' => 'Delete Expenses']);
        Permission::create(['name' => 'View Expenses']);
        Permission::create(['name' => 'Edit Expenses']);

        Permission::create(['name' => 'Add Guarantors']);
        Permission::create(['name' => 'Delete Guarantors']);
        Permission::create(['name' => 'View Guarantors']);
        Permission::create(['name' => 'Edit Guarantors']);

        Permission::create(['name' => 'Add Loantype']);
        Permission::create(['name' => 'Delete Loantype']);
        Permission::create(['name' => 'View Loantype']);
        Permission::create(['name' => 'Edit Loantype']);

        Permission::create(['name' => 'Add Journals']);
        Permission::create(['name' => 'Delete Journals']);
        Permission::create(['name' => 'View Journals']);
        Permission::create(['name' => 'Edit Journals']);

        Permission::create(['name' => 'View Mpesa Transactions']);


        Permission::create(['name' => 'Add Permissions']);
        Permission::create(['name' => 'Delete Permissions']);
        Permission::create(['name' => 'View Permissions']);
        Permission::create(['name' => 'Edit Permissions']);

        Permission::create(['name' => 'Add Accounts']);
        Permission::create(['name' => 'Delete Accounts']);
        Permission::create(['name' => 'View Accounts']);
        Permission::create(['name' => 'Edit Accounts']);

        Permission::create(['name' => 'Settings Management']);
        Permission::create(['name' => 'Organisation Management']);
        Permission::create(['name' => 'Appearance Management']);
        Permission::create(['name' => 'Billing Management']);
        Permission::create(['name' => 'Integrations Management']);
        Permission::create(['name' => 'System Management']);
        Permission::create(['name' => 'Security Management']);
        Permission::create(['name' => 'Plans Management']);
        Permission::create(['name' => 'View Reports']);



        // create roles and assign created permissions

        // this can be done as separate statements

        // $user = User::create([
        //     'name' => 'Admin',
        //     'email' => 'admin@loanapp.com',
        //     'password' => Hash::make('S5E6mBRp!'),
        //     'email_verified_at' => now()
        // ]);
        $user = User::first();

        $role = Role::create(['name' => 'Super admin']);
        $role->givePermissionTo(Permission::all());

        $user->assignRole($role);
    }
}
