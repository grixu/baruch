<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class CreateGroupsPermissions extends Seeder
{
    public function run()
    {
        $createGroup = Permission::firstOrCreate(['name' => 'group_create']);
        $deleteGroup = Permission::firstOrCreate(['name' => 'group_delete']);

        $inviteToGroup = Permission::firstOrCreate(['name' => 'group_invite']);
    }
}
