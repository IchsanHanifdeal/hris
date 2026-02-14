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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained();
            $table->foreignId('shift_id')->nullable()->constrained(); 
            $table->foreignId('schedule_id')->nullable()->constrained(); 
            $table->date('date');
            
            $table->time('time_in')->nullable();
            $table->decimal('lat_in', 10, 8)->nullable(); 
            $table->decimal('long_in', 11, 8)->nullable();
            $table->string('photo_in')->nullable(); 
            
            $table->time('time_out')->nullable();
            $table->decimal('lat_out', 10, 8)->nullable();
            $table->decimal('long_out', 11, 8)->nullable();
            $table->string('photo_out')->nullable();
            
            $table->enum('status', ['on_time', 'late', 'overtime'])->default('on_time');
            $table->timestamps();
        });

        Schema::create('leave_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('quota')->default(12); 
            $table->timestamps();
        });

        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained();
            $table->foreignId('leave_type_id')->constrained();
            $table->date('start_date');
            $table->date('end_date');
            $table->text('reason');
            $table->string('attachment')->nullable(); 
            
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('approved_by')->nullable()->constrained('users'); 
            $table->dateTime('approved_at')->nullable();
            $table->text('rejection_note')->nullable(); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
        Schema::dropIfExists('leave_types');
        Schema::dropIfExists('leave_requests');
    }
};
