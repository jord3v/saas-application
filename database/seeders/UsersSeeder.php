<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Administrador do sistema',
            'email' => 'jorgemiguelto@gmail.com',
            'google_id' => '101754329172984083120',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Administrador');
    }
}
