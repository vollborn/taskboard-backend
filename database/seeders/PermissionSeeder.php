<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = Permission::getAllNames();
        foreach ($names as $name) {
            Permission::query()
                ->firstOrCreate([
                    'name' => $name
                ]);
        }
    }
}
