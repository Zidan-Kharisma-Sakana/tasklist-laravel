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
            $table->timestamps();
            $table->string("title");
            $table->text("description")->nullable();
            $table->integer("status")->default(1);
            $table->dateTime("deadline");
            $table->foreignId('user_id')->constrained(
                table: 'users',
                column: 'id',
                indexName: 'task_user_id',
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // drop existing foreign keys
        Schema::table('tasks', function (Blueprint $table) {
            if (Schema::hasColumn('tasks', 'user_id')) {
                $table->dropForeign(['user_id']);
            }
        });
        Schema::dropIfExists('tasks');
    }
};
