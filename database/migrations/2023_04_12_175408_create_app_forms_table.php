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
        if(!Schema::hasTable('app_forms')){
        Schema::create('app_forms', function (Blueprint $table) {
            $table->id();
            $table->string('app_name');
            $table->string('author_id')->nullable();
            $table->string('author_name')->nullable();
            $table->enum('type', array('glitch', 'information', 'question'))->default('question');
            $table->text('description');
            $table->text('place')->nullable();
            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_forms');
    }
};
