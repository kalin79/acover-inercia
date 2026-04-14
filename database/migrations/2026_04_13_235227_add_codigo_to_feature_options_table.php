<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('feature_options', function (Blueprint $table) {
            $table->string('codigo')->nullable()->after('value');
            // nullable = permite que esté vacío (opcional)
        });
    }

    public function down(): void
    {
        Schema::table('feature_options', function (Blueprint $table) {
            $table->dropColumn('codigo');
        });
    }
};