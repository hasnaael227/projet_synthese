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
        Schema::create('progressions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('etudiant_id')->constrained('etudiants')->onDelete('cascade');
    $table->foreignId('cours_id')->constrained('cours')->onDelete('cascade');
    $table->boolean('completed')->default(false);
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progressions');
    }
};
