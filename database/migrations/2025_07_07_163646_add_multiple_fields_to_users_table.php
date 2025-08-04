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
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('photo')->nullable();
            $table->enum('sexe', ['Masculin', 'Feminin']);
            $table->date('date_naissance')->nullable();
            $table->string('lieu')->nullable();
            $table->string('telephone')->nullable();
            $table->string('adresse')->nullable();
            $table->foreignId('filiere_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('specialite_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('niveau_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->enum('role', [
                'admin',
                'comptable',
                'user'
            ])->default('user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
