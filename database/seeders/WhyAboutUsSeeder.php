<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\WhyAboutUs;
class WhyAboutUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	WhyAboutUs::truncate();

    	
        $tarjetas = array(
		    [
			    'title' => '¿Por qué consumir Cacahuarte?',
			    'description' => 'Es un producto 100% artesanal, manejamos derivados del cacao. En caso de ser un producto endulzado se realiza con panela orgánica, contamos con todos los procesos de producción desde la materia prima hasta el producto final ya que se elabora directamente desde el campo, talento humano de la misma región.',
			    'icon_id' => '1', 
			    'state' => '1'
		    ],
		    [
		    	'title' => 'Contamos con BPA', 
		    	'description' => 'Elías Huila, aquí es donde nace nuestro árbol de cacao. Somos certificados con BPA, ya que queremos para ustedes un producto de alta calidad cumpliendo con las técnicas exigidas también minimizar el impacto ambiental negativo y darle bienestar y seguridad a todos nuestros colaboradores.', 
		    	'icon_id' => '2', 
		    	'state' => '2'
		    ],
		    [
		    	'title' => 'Análisis sensorial', 
		    	'description' => 'Podrás saber de la composición del cacao y todo los valores agregados de el análisis realizado', 
		    	'icon_id' => '3', 
		    	'state' => '2'
		    ],
		    [
		    	'title' => 'Galería de campo', 
		    	'description' => 'Aquí podrás conocer un poco mas sobre nuestro emprendimiento', 
		    	'icon_id' => '1', 
		    	'state' => '2'
		    ]
		);

		$registros = count($tarjetas);
		for ($i=0;$i<$registros;$i++) {
			DB::table('why_about_us')->insert($tarjetas[$i]);
		}
    }
}
