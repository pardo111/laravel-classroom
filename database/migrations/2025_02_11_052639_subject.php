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
        Schema::create('subject', function (Blueprint $table) {
            $table->id();
            $table->string('subject', 50);
            $table->string('code', 15)->unique();
            $table->foreignId('owner')->constrained('users');
            $table->string('description', 1000);
            $table->unsignedSmallInteger('duration')->unsigned();
            $table->unsignedSmallInteger('price')->unsigned();
            $table->boolean('state')->default(true);  
            $table->timestamps();
        });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject');
    }
};
