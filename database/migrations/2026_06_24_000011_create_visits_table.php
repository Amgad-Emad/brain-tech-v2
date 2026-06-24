<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->string('path')->index();
            $table->string('route_name')->nullable();
            $table->string('locale', 8)->nullable();
            $table->string('device', 16)->nullable();      // Desktop / Mobile / Tablet
            $table->string('source')->nullable();           // Direct / Google / ...
            $table->string('referrer')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('ip')->nullable();               // masked
            $table->string('visitor_id', 40)->nullable()->index();
            $table->string('session_id', 40)->nullable()->index();
            $table->unsignedInteger('duration')->default(0); // seconds on page
            $table->timestamp('created_at')->nullable()->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
