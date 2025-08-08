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
        Schema::table('conversations', function (Blueprint $table) {
            $table->foreignId('native_language_id')->after('id')->constrained('languages')->onDelete('cascade');
            $table->foreignId('practising_language_id')->after('native_language_id')->constrained('languages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('conversations', function (Blueprint $table) {
            $table->dropForeign(['native_language_id']);
            $table->dropForeign(['practising_language_id']);
            
            $table->dropColumn(['native_language_id', 'practising_language_id']);
        });
    }
};
