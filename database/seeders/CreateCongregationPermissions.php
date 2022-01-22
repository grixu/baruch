<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class CreateCongregationPermissions extends Seeder
{
    public function run()
    {
        $createCongregation = Permission::firstOrCreate(['name' => 'congregation_create']);
        $deleteCongregation = Permission::firstOrCreate(['name' => 'congregation_delete']);

        $inviteToCongregation = Permission::firstOrCreate(['name' => 'congregation_invite']);
    }
}
