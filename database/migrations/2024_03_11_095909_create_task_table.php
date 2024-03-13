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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->string('content');
            $table->json('attachment')->nullable();
            $table->json('subtask')->nullable();
            $table->enum('status', [0, 1, 2])->default(0); // (0:to-do, 1:in-progress, 2:done)
            $table->boolean('is_published')->default(true); // (1:true, 0:false)
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::dropIfExists('tasks');
    }
};
