<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('criterias', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->decimal('weight', 5, 2);
            $table->enum('type', ['benefit', 'cost']);
            $table->timestamps();
        });

        // Tabel Sub Kriteria (Dinamis)
        Schema::create('sub_criterias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('criteria_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->decimal('value', 8, 2);
            $table->timestamps();
        });

        // Tabel Alternatif (Biji Kopi)
        Schema::create('coffee_alternatives', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Tabel Penilaian
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coffee_alternative_id')->constrained()->onDelete('cascade');
            $table->foreignId('criteria_id')->constrained()->onDelete('cascade');
            $table->foreignId('sub_criteria_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['coffee_alternative_id', 'criteria_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
        Schema::dropIfExists('coffee_alternatives');
        Schema::dropIfExists('sub_criteria');
        Schema::dropIfExists('criteria');
    }
};
