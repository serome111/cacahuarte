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
		    ['icon_name' => 'Corazon', 'icon_class' => 'icofont-pulse', 'icon_hex_code' => 'ec31'],
		    ['icon_name' => 'Doctor', 'icon_class' => 'icofont-surgeon', 'icon_hex_code' => 'ec36'],
		    ['icon_name' => 'Arbol', 'icon_class' => 'icofont-tree-alt', 'icon_hex_code' => 'e824'],
		    ['icon_name' => 'Hoja', 'icon_class' => 'icofont-leaf', 'icon_hex_code' => 'ef5e'],
		    ['icon_name' => 'Mundo', 'icon_class' => 'icofont-world', 'icon_hex_code' => 'f02c'],
		    ['icon_name' => 'Mug', 'icon_class' => 'icofont-coffee-mug', 'icon_hex_code' => 'eb57'],
		    ['icon_name' => 'Certificado', 'icon_class' => 'icofont-certificate', 'icon_hex_code' => 'ead6']
		);
    	$registros = count($icons);
		for ($i=0;$i<$registros;$i++) {
			DB::table('icons')->insert($icons[$i]);
		}

    }
}
