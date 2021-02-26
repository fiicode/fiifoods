<?php

namespace Database\Seeders;

use App\Model\Option;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Option::create([
            'name' => 'commande',
            'menu' => true,
        ]);
        Option::create([
            'name' => 'vente',
            'menu' => true,
        ]);
        Option::create([
            'name' => 'bilan',
            'menu' => true,
        ]);
    }
}
