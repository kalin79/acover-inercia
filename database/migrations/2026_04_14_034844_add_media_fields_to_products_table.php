<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('banner_pc')->nullable();
            $table->string('banner_mobile')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('technical_document')->nullable(); // PDF u otro documento
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['banner_pc', 'banner_mobile', 'cover_image', 'technical_document']);
        });
    }
};