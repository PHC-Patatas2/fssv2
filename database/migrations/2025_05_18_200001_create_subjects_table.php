<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('year_id');
            $table->unsignedBigInteger('semester_id');
            $table->unsignedBigInteger('major_id')->nullable();
            $table->string('code')->unique();
            $table->string('name');
            $table->enum('type', ['major', 'minor']);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('year_id')->references('id')->on('years')->onDelete('cascade');
            $table->foreign('semester_id')->references('id')->on('semesters')->onDelete('cascade');
            $table->foreign('major_id')->references('id')->on('majors')->nullOnDelete();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
