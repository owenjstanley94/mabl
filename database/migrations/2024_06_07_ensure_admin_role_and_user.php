<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Models\User;

return new class extends Migration
{
    public function up(): void
    {
        // Ensure the admin role exists
        $role = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        // Ensure the user exists
        $user = User::firstOrCreate(
            [
                'email' => 'owenjstanley94@gmail.com',
            ],
            [
                'name' => 'Owen Stanley',
                'password' => Hash::make('Poole2Preston'),
            ]
        );

        // Assign the admin role to the user
        if (! $user->hasRole('admin')) {
            $user->assignRole('admin');
        }
    }

    public function down(): void
    {
        // Remove the admin role from the user
        $user = User::where('email', 'owenjstanley94@gmail.com')->first();
        if ($user && $user->hasRole('admin')) {
            $user->removeRole('admin');
        }
        // Optionally, delete the user
        // if ($user) {
        //     $user->delete();
        // }
        // Optionally, delete the admin role if no users have it
        // $role = Role::where('name', 'admin')->first();
        // if ($role && $role->users()->count() === 0) {
        //     $role->delete();
        // }
    }
}; 