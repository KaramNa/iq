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
        $users = User::count();
        if ($users == 0) {
            User::create([
                'name' => 'karam',
                'email' => env('DEFAULT_EMAIL'),
                'email_verified_at' => date("Y-m-d h:i:s"),
                'password' => bcrypt('KaramElie2022')
            ]);
        }
        User::create([
            'name' => 'Elie',
            'email' => 'admin2@admin.com',
            'email_verified_at' => date("Y-m-d h:i:s"),
            'password' => bcrypt('ElieKaram2022')
        ]);
    }
}
