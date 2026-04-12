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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('app_name')->default('HRIS PRO');
            $table->string('app_logo')->nullable();
            $table->string('app_favicon')->nullable();
            $table->string('pwa_name')->nullable();
            $table->string('pwa_logo')->nullable();
            $table->time('check_in_time')->nullable();
            $table->time('check_out_time')->nullable();
            $table->text('address')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->integer('radius')->default(100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
