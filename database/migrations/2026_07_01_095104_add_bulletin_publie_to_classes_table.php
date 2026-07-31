<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('classes', function (Blueprint $table) {
            // Autorisation de publication des bulletins par semestre
            $table->boolean('bulletin_s1_publie')->default(false)->after('annee_scolaire');
            $table->boolean('bulletin_s2_publie')->default(false)->after('bulletin_s1_publie');
        });
    }

    public function down(): void
    {
        Schema::table('classes', function (Blueprint $table) {
            $table->dropColumn(['bulletin_s1_publie', 'bulletin_s2_publie']);
        });
    }
};