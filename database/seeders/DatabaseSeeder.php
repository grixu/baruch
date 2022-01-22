<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(CreateCongregationPermissions::class);
        $this->call(CreateGroupsPermissions::class);
        $this->call(CreateSuperAdminRole::class);
        $this->call(CreateAdminAndUserSeeder::class);
    }
}
