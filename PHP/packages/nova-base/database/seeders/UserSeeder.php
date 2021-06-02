<?php

namespace Larabase\NovaDatabase\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @command php artisan db:seed --class=Larabase\NovaDatabase\Seeders\UserSeeder
     * @return void
     */
    public function run()
    {
        collect($tables = [
            'model_has_roles',
            'model_has_permissions',
            'role_has_permissions',
            'users',
            'roles',
            'permissions',
        ])->each(function ($item) {
            $statement = "TRUNCATE TABLE {$item} RESTART IDENTITY";
            if (in_array($item, ['roles', 'permissions'])) $statement .= ' CASCADE';
            DB::statement($statement);
        });

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // USERS -----------------------------------------------------------------------------

        $users = [
            ['id' => 1, 'name' => 'superadmin', 'email' => 'superadmin@superadmin.com', 'password' => Hash::make('superadmin')],
            ['id' => 2, 'name' => 'admin', 'email' => 'admin@admin.com', 'password' => Hash::make('admin')],
            ['id' => 3, 'name' => 'manager', 'email' => 'manager@manager.com', 'password' => Hash::make('manager')],
            ['id' => 4, 'name' => 'editor', 'email' => 'editor@editor.com', 'password' => Hash::make('editor')],
            ['id' => 5, 'name' => 'guest', 'email' => 'guest@guest.com', 'password' => Hash::make('guest')],
        ];

        collect($users)->each(fn($u) => User::create($u));

        // PERMISSIONS -----------------------------------------------------------------------------
        $permissions = collect([
            'users',
            'roles',
            'permissions',
        ])->each(function ($item) {
            Permission::create(['name' => $item]);

            collect([
                'create', 'create-own', 'update', 'update-own', 'view', 'delete', 'restore', 'force-delete', 'download'
            ])->each(fn($action) => Permission::create(['name' => implode('.', [$item, $action])]));
        });

        $admin_permissions = collect([
            'users.change-status',
            'users.impersonate',
            'users.reset-password',
            'activity-log',
            'backup',
            'settings',
            'menu-builder',
            'filemanager',
        ]);

        $admin_permissions->merge([
            'log',
            'command-runner',
            'route-viewer',
            'filemanager.create_folder',
        ])->each(fn($name) => Permission::create(['name' => $name]));

        // ROLES -----------------------------------------------------------------------------
        collect($roles = ['superadmin', 'admin', 'manager', 'editor', 'guest'])
            ->each(function ($item) use ($permissions, $admin_permissions) {
                $role = Role::create(['name' => $item]);
                $user = User::where('email', 'like', $item . '@%')->get();
                $user->each(fn($u) => $u->assignRole($role->name));

                switch ($role->name) {
                    case 'admin':
                        $permissions
                            ->merge($admin_permissions)
                            ->merge([
                            'settings',
                            'filemanager',
                        ])->each(fn($p) => $role->givePermissionTo($p));
                        break;
                }
            });

    }
}
