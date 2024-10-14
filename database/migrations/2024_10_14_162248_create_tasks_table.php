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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assigned_to');
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->tinyInteger('priority');
            $table->string('title',50);
            $table->string('desc',500);
            $table->tinyInteger('status')->default(1);
            $table->timestamp('estimated_time');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
