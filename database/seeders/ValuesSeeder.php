<?php

namespace Database\Seeders;

use App\Models\Values;
use Illuminate\Database\Seeder;

class ValuesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Values::truncate();

    	for ($i=1; $i < 5; $i++) {
	    	Values::create([
	            'title' => 'Equipo de mujeres emprendedoras',
	            'description' => 'Lorem ipsum dolor sit amet, consectetur elit, sed do eiusmod tempor ut labore et dolore magna aliqua.',
	            'picture' => '/storage/values/values-'.$i.'.jpg',
	            'link' => '#',
	            'state' => 1,
	            'created_at' => date('Y-m-d H:i:s'),
	            'updated_at' => date('Y-m-d H:i:s'),
	        ]);
       	}


    }
}
