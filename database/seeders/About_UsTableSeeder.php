<?php

namespace Database\Seeders;

use App\Models\AboutUs;
use Illuminate\Database\Seeder;

class About_UsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	AboutUs::truncate();

    	AboutUs::create([
            'title' => 'Equipo de mujeres emprendedoras',
            'description' => 'somos un grupo de mujeres emprendedoras del municipio de elias huila, queremos mejorar nuestra region y a partir de nuestra riqueza agricola ofrecer un producto de calidad para el consumo en el hogar u oficina',
            'photo' => '/storage/about_us/about-img.jpg',
            'link' => 'required',

            'title1' => '100% Natural',
            'description1' => 'sin programas malignos',
            'favicon1' => '1',

            'title2' => '100% huilense',
            'description2' => 'Hecho con el corazon',
            'favicon2' => '1',

            'title3' => '100% huilense',
            'description3' => 'Hecho por nosotros',
            'favicon3' => '1'

        ]);
    }
}
