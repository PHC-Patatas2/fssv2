<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('schedule_batches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('status')->default('draft'); // draft, exported, etc.
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        // Add batch_id to schedules
        Schema::table('schedules', function (Blueprint $table) {
            $table->unsignedBigInteger('batch_id')->nullable()->after('id');
            $table->foreign('batch_id')->references('id')->on('schedule_batches')->onDelete('set null');
        });
    }
    public function down(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropForeign(['batch_id']);
            $table->dropColumn('batch_id');
        });
        Schema::dropIfExists('schedule_batches');
    }
};
