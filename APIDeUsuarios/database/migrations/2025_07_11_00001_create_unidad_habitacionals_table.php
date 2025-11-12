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
        Schema::create('unidad_habitacionals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('etapa_id'); 
            $table->foreign('etapa_id')
                ->references('id')
                ->on('etapas');
            $table->string('door');
            $table->string('street');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unidad_habitacionals');
    }
};
