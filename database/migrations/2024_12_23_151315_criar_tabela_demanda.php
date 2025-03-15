<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('demandas', function (Blueprint $table) {
            $table->id()->primary();
            $table->uuid('_id');
            $table->integer('origem_id')->constrained('origens');
            $table->integer('solicitante_id')->constrained('solicitantes');
            $table->integer('categoria_id')->constrained('categorias');
            $table->integer('subcategoria_id')->constrained('subcategorias');
            $table->integer('recebido_por_agente_id')->constrained('agentes');
            $table->integer('status_id')->constrained('status');
            $table->integer('grupo_solucao_id')->constrained('grupo_solucoes');
            $table->integer('agente_solucao_id')->constrained('agentes');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demandas', function (Blueprint $table) {
            $table->dropForeign(['origem_id']);
            $table->dropForeign(['solicitante_id']);
            $table->dropForeign(['categoria_id']);
            $table->dropForeign(['subcategoria_id']);
            $table->dropForeign(['recebido_por_agente_id']);
            $table->dropForeign(['status_id']);
            $table->dropForeign(['grupo_solucao_id']);
            $table->dropForeign(['agente_solucao_id']);
        });

        Schema::dropIfExists('demandas');
    }
};
