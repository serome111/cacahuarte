<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class RenameCacaoAlinadoProductType extends Migration
{
    public function up()
    {
        DB::table('cost_product_types')
            ->where('slug', 'cacao-alinado')
            ->orWhere('name', 'CACAO ALIÑADO')
            ->update([
                'name' => 'CHOCOLATE DE MESA ALIÑADO',
                'slug' => 'chocolate-de-mesa-alinado',
                'updated_at' => now(),
            ]);
    }

    public function down()
    {
        DB::table('cost_product_types')
            ->where('slug', 'chocolate-de-mesa-alinado')
            ->orWhere('name', 'CHOCOLATE DE MESA ALIÑADO')
            ->update([
                'name' => 'CACAO ALIÑADO',
                'slug' => 'cacao-alinado',
                'updated_at' => now(),
            ]);
    }
}
