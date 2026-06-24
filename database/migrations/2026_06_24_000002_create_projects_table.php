<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->json('name');
            $table->json('tag');
            $table->string('year', 8)->nullable();
            $table->string('metric')->nullable();
            $table->json('metric_label')->nullable();
            $table->json('client')->nullable();
            $table->string('image_path')->nullable();
            $table->json('alt')->nullable();
            $table->json('summary')->nullable();
            $table->json('challenge')->nullable();
            $table->json('approach')->nullable();
            $table->json('results')->nullable();
            $table->json('services_used')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
