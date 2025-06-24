<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('servico_prestadores', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('prestador_id');
            $table->unsignedBigInteger('servico_id');

            // Campos obrigatórios para o cálculo de custo
            $table->integer('km_saida')->default(0);
            $table->decimal('valor_saida', 8, 2)->default(0);
            $table->decimal('valor_km_excedente', 8, 2)->default(0);

            $table->timestamps();

            // FKs
            $table->foreign('prestador_id')->references('id')->on('prestadores')->onDelete('cascade');
            $table->foreign('servico_id')->references('id')->on('servicos')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('servico_prestadores');
    }
};
