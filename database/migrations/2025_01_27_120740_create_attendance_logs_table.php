<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('attendance_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->datetime('check_in')->nullable();
            $table->datetime('check_out')->nullable();
            $table->point('check_in_location')->nullable();
            $table->point('check_out_location')->nullable();
            $table->string('late_reason')->nullable();
            $table->string('early_leave_reason')->nullable();
            $table->boolean('is_late')->default(false);
            $table->boolean('is_early_leave')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_logs');
    }
};
