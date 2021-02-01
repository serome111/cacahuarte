<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Icon;
class IconsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {	
        Icon::truncate();

    	$icons = array(
		    ['icon_name' => 'ADN', 'icon_class' => 'icofont-dna', 'icon_hex_code' => 'ec17'],
		    ['icon_name' => 'Heart', 'icon_class' => 'icofont-pulse', 'icon_hex_code' => 'ec31'],
		    ['icon_name' => 'Doctor', 'icon_class' => 'icofont-surgeon', 'icon_hex_code' => 'ec36']
		);
    	$registros = count($icons);
		for ($i=0;$i<$registros;$i++) {
			DB::table('icons')->insert($icons[$i]);
		}
        
    }
}
