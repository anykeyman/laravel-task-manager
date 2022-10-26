<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InitialTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->alias = 'admin';
        $role->name = 'Administator';
        $role->save();

        $admin = new User();
        $admin->password = 'dadadada';
        $admin->name = 'Admin';
        $admin->email = 'admin@local.com';
        $admin->save();
    }
}
