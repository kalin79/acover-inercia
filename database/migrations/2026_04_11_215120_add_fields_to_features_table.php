<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('features', function (Blueprint $table) {
            $table->foreignId('feature_group_id')
                ->nullable()
                ->after('id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('type')->default('text')->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('features', function (Blueprint $table) {
            $table->dropForeign(['feature_group_id']);
            $table->dropColumn(['feature_group_id', 'type']);
        });
    }
};
