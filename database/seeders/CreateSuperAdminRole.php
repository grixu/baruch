<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class CreateSuperAdminRole extends Seeder
{
    public function run()
    {
        Role::firstOrCreate(['name' => 'super_admin']);
    }
}
