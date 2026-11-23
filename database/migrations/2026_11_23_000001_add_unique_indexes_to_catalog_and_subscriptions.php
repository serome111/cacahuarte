<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['products' => 'code', 'bulletings' => 'email'] as $table => $column) {
            if (DB::table($table)->select($column)->groupBy($column)->havingRaw('COUNT(*) > 1')->exists()) {
                throw new RuntimeException("Resuelve los valores duplicados de $table.$column antes de migrar.");
            }
        }

        foreach (['products' => 'code', 'bulletings' => 'email'] as $table => $column) {
            Schema::table($table, fn (Blueprint $schema) => $schema->unique($column));
        }
    }

    public function down(): void
    {
        Schema::table('products', fn (Blueprint $table) => $table->dropUnique(['code']));
        Schema::table('bulletings', fn (Blueprint $table) => $table->dropUnique(['email']));
    }
};
