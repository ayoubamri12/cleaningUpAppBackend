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
        // Nous utilisons Schema::table car la table existe déjà et nous voulons ajouter ou modifier des colonnes.
        Schema::table('services', function (Blueprint $table) {
            
            // Si ces colonnes existent, cette méthode les met à jour (si elles n'existent pas, la migration échouera).
            // Si vous partez d'une table vide (après migrate:fresh), vous pouvez les ajouter.

            // S'assurer que les colonnes clés existent
            $table->string('title');
            $table->text('description')->change();
            
            // Nouveau champ pour le prix standard (obligatoire)
            $table->decimal('price', 10, 2)->default(0.00);
                        
            // Champ JSON pour stocker une liste d'inclusions (ex: ["Produits Eco", "Garantie 24h"])
            $table->json('includes')->nullable()->after('price');
            
            // Champ statut (si non présent)
            $table->boolean('active')->default(true);

            // Si vous aviez des colonnes ID, created_at/updated_at, elles ne sont pas touchées par Schema::table.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Si vous annulez la migration, nous supprimons uniquement les colonnes que nous avons ajoutées
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('old_price');
            $table->dropColumn('includes');
            // Nous ne faisons pas de 'dropColumn' sur 'price' ou 'active' au cas où elles seraient essentielles.
        });
    }
};
