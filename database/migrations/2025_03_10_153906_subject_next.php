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
        Schema::create('subject_next', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject')->constrained('subject');
            $table->foreignId('subject_next')->constrained('subject');
        });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject_next');
    }
};
