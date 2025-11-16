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
        Schema::create('sidebars', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('name');
            $table->foreignId('parent_id')->nullable();
            $table->timestamps();
        });

        Schema::create('permission_sidebar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permission_id');
            $table->foreignId('sidebar_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sidebars');
        Schema::dropIfExists('permission_sidebar');
    }
};
