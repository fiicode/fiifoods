<?php

namespace Database\Seeders;

use \Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'root',
            'username' => 'root',
            'email' => 'root@fiifoods.com',
            'password' => '$2y$10$/SKm74T0fwAFIehMEdxYau2Kx/sCqdI1rXEy8AZo3JtmFkRomXxQC',
            // 'role_id' => '1'
        ]);
    }
}
