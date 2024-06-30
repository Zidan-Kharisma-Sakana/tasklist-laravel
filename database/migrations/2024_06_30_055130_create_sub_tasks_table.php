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
        Schema::create('sub_tasks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("title");
            $table->text("description")->nullable();
            $table->integer("status")->default(1);
            $table->dateTime("deadline");
            $table->foreignId('task_id')->constrained(
                table: 'tasks',
                column: 'id',
                indexName: 'task_subtask_id',
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // drop existing foreign keys
        Schema::table('sub_tasks', function (Blueprint $table) {
            if (Schema::hasColumn('sub_tasks', 'task_id')) {
                $table->dropForeign(['task_id']);
            }
        });
        Schema::dropIfExists('sub_tasks');
    }
};
