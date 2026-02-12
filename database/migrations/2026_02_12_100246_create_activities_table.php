<?php

// database/migrations/xxxx_xx_xx_create_activities_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->string('subject_type'); // Project / Task vs
            $table->unsignedBigInteger('subject_id');
            $table->string('event'); // created, updated, moved, commented, deleted
            $table->json('properties')->nullable();
            $table->timestamps();

            $table->index(['subject_type','subject_id','created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
