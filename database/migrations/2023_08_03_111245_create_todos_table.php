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
        Schema::create('todos', function (Blueprint $table) {
            $table->id();
            $table->string('activity');
            $table->unsignedBigInteger('user_id')->nullable()->unsigned();
            $table->enum("status", ['Completed', 'Incompleted'])->default("Incompleted");
            $table->unsignedBigInteger('day_id')->nullable()->unsigned();

            $table->foreign("user_id")->references("id")->on("users")->cascadeOnDelete();
            $table->foreign("day_id")->references("id")->on("days")->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todos');
    }
};
