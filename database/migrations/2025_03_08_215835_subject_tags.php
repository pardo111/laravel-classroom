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
        Schema::create('subject_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->constrained('subject')->onDelete('cascade');
            $table->foreignId('tags_id')->constrained('tags')->onDelete('cascade'); 
        });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject_tags');
    }
};
