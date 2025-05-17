<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('normal'); // normal, exam, etc.
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->unsignedBigInteger('room_id')->nullable();
            $table->string('day');
            $table->time('start_time');
            $table->time('end_time');
            $table->unsignedBigInteger('created_by');
            $table->enum('status', ['active', 'cancelled', 'pending'])->default('active');
            $table->timestamps();

            $table->foreign('subject_id')->references('id')->on('subjects')->nullOnDelete();
            $table->foreign('teacher_id')->references('id')->on('teachers')->nullOnDelete();
            $table->foreign('room_id')->references('id')->on('rooms')->nullOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
