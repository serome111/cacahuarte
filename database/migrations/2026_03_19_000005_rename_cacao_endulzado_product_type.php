<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class RenameCacaoEndulzadoProductType extends Migration
{
    public function up()
    {
        DB::table('cost_product_types')
            ->where('slug', 'cacao-endulzado')
            ->orWhere('name', 'CACAO ENDULZADO')
            ->update([
                'name' => 'CHOCOLATE DE MESA ENDULZADO',
                'slug' => 'chocolate-de-mesa-endulzado',
                'updated_at' => now(),
            ]);
    }

    public function down()
    {
        DB::table('cost_product_types')
            ->where('slug', 'chocolate-de-mesa-endulzado')
            ->orWhere('name', 'CHOCOLATE DE MESA ENDULZADO')
            ->update([
                'name' => 'CACAO ENDULZADO',
                'slug' => 'cacao-endulzado',
                'updated_at' => now(),
            ]);
    }
}
