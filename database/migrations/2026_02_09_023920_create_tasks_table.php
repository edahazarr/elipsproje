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

        $table->foreignId('project_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->string('title');
        $table->text('description')->nullable();

        // todo | doing | done
        $table->string('status')->default('todo');

        // görev bir kullanıcıya atanabilir (opsiyonel)
        $table->foreignId('assigned_user_id')
            ->nullable()
            ->constrained('users')
            ->nullOnDelete();

        $table->date('due_date')->nullable();

        $table->boolean('is_active')->default(true);

        $table->timestamps();
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
