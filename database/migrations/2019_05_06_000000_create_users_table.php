<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('field_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('entrance_term_id')->nullable()->constrained('terms')->cascadeOnDelete();
            $table->string('name');
            $table->string('family');
            $table->enum('gender', ['M','F'])->nullable();
            $table->string('username')->unique();
            $table->string('national_code')->nullable();
            $table->boolean('is_allowed')->default(false);
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('group_manager');
    }
};
