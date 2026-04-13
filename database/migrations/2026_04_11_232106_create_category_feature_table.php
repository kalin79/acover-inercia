<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('category_feature', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('feature_id')->constrained()->onDelete('cascade');

            $table->boolean('is_filter')->default(true);      // ¿Se usa como filtro en la web?
            $table->boolean('show_in_specs')->default(true);  // ¿Se muestra en especificaciones técnicas?
            $table->integer('sort_order')->default(0);        // Orden de aparición

            $table->timestamps();

            $table->unique(['category_id', 'feature_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_feature');
    }
};