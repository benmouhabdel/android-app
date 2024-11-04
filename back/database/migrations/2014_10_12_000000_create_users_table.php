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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('image_url')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->string('role')->default('user'); // Ajout de la colonne 'role'
            $table->string('registration_key')->nullable();
            $table->string('phone')->nullable();

            // Ajout des colonnes 'annee' et 'filiere' comme enum
            $table->enum('annee', ['1', '2', '3', '4', '5'])->nullable();
            $table->enum('filiere', ['IAM', 'Ingénierie', 'RH', 'Management', 'Finance', 'Marketing'])->nullable();
            $table->string('classe')->nullable(); // Classe comme string si vous voulez la gérer différemment
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
