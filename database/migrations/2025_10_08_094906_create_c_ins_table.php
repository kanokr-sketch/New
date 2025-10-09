<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('c_ins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // เชื่อมกับตาราง users
            $table->date('date')->nullable(); // วันที่
            $table->timestamp('check_in')->nullable(); // เวลาเช็คอิน
            $table->timestamp('check_out')->nullable(); // เวลาเช็คเอาท์
            $table->decimal('work_hours', 5, 2)->nullable(); // ชั่วโมงการทำงาน เช่น 8.50 ชั่วโมง
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('c_ins');
    }
};
