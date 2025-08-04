<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Rendre `tranche_paye` nullable
        Schema::table('paiements', function (Blueprint $table) {
            $table->string('tranche_paye')->nullable()->change();
        });

        // 2. Changer le champ `statut` pour plus de flexibilité
        Schema::table('paiements', function (Blueprint $table) {
            $table->string('statut')->default('en_cours')->change();
        });

        // 3. Mettre à jour les anciennes valeurs de statut
        DB::table('paiements')
            ->where('statut', 'valide')
            ->update(['statut' => 'complet']);

        DB::table('paiements')
            ->where('statut', 'en_attente')
            ->update(['statut' => 'en_cours']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paiements', function (Blueprint $table) {
            $table->string('tranche_paye')->nullable(false)->change();
            $table->enum('statut', ['en_attente', 'valide', 'rejete'])->default('en_attente')->change();
        });

        // Remettre à jour les valeurs
        DB::table('paiements')
            ->where('statut', 'complet')
            ->update(['statut' => 'valide']);

        DB::table('paiements')
            ->where('statut', 'en_cours')
            ->update(['statut' => 'en_attente']);
    }
};