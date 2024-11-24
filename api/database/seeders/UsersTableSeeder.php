<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'      => 'Usuário Admin',
            'email'     => 'usuarioadmin@teste.com',
            'password'  => Hash::make('senhaadmin'),
            'role_id'   => Role::ID_ADMIN
        ]);
    }
}
