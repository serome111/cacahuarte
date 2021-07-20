<?php

namespace Database\Seeders;

// use App\Models\Values;

use App\Models\Role;
use Illuminate\Database\Seeder;

class Roles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
	            'name' => 'admin',
	            'description' => 'El encargado de todo!',
	            'created_at' => date('Y-m-d H:i:s'),
	            'updated_at' => date('Y-m-d H:i:s'),
	        ]);
        Role::create([
	            'name' => 'Vendedor',
	            'description' => 'Solo acceso a sistema de inventario y chat con clientes',
	            'created_at' => date('Y-m-d H:i:s'),
	            'updated_at' => date('Y-m-d H:i:s'),
	        ]);
    }
}
