<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('_users', function (Blueprint $table) {
            $table->id();
            $table->string('login');
            $table->string('email');
            $table->string('password');
            $table->binary('image');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('_users');
    }
};
