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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->char('nik', 16)->unique()->nullable();
            $table->string('name');
            $table->string('username', 50)->unique();
            $table->string('password');
            $table->string('telp', 15)->nullable();
            $table->enum('role', ['admin', 'petugas', 'masyarakat'])->default('masyarakat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
