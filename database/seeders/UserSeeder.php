<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        foreach ($this->getData() as $data) {
            User::query()
                ->updateOrCreate([
                    'id' => $data['id']
                ], [
                    'username'   => $data['username'],
                    'password'   => Hash::make($data['password']),
                    'first_name' => $data['first_name'],
                    'last_name'  => $data['last_name'],
                ]);
        }
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            [
                'id'         => User::ADMIN_ID,
                'username'   => 'admin',
                'password'   => 'admin',
                'first_name' => 'Taskboard',
                'last_name'  => 'Admin',
            ]
        ];
    }
}
