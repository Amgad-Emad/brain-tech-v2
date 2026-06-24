<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('icon_key')->default('software');
            $table->string('slug')->unique();
            $table->json('title');
            $table->json('description');
            $table->json('tagline')->nullable();
            $table->json('long_description')->nullable();
            $table->json('deliverables')->nullable();
            $table->boolean('offer_enabled')->default(false);
            $table->json('offer_label')->nullable();
            $table->json('offer_title')->nullable();
            $table->json('offer_text')->nullable();
            $table->json('offer_until')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
