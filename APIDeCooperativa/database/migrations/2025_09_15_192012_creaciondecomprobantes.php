<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comprobantes', function (Blueprint $table) {
            $table->id();
            $table->date('dateManaged')->nullable();
            $table->date('date');
            $table->string('type');
            $table->smallInteger('totalAmount');
            $table->tinyInteger('totalHours');
            $table->string('state')->default('Pending');
            $table->string('evidence');
            $table->string('evidenceType');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->unsignedBigInteger('administrador_id')->nullable(); 
            $table->foreign('administrador_id')
                ->references('id')
                ->on('administradors');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comprobantes');
    }
};
