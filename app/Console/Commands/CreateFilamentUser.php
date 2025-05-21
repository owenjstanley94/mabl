<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class CreateFilamentUser extends Command
{
    protected $signature = 'filament:user {name} {email} {password}';
    protected $description = 'Create a new Filament user';

    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password');

        // Validate input
        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ], [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        }

        // Create user
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        // Assign Filament user role
        $user->assignRole('filament_user');

        $this->info('User created successfully!');
        $this->table(
            ['Name', 'Email', 'Role'],
            [[$user->name, $user->email, 'filament_user']]
        );

        return 0;
    }
} 