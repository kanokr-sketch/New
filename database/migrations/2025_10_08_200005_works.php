<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('works', function (Blueprint $table) {
            $table->id();

            // อ้างอิงไปยัง user ที่ทำงาน
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // วันที่ทำงาน
            $table->date('date')->nullable();

            // จำนวนชั่วโมงที่ทำงานในวันนั้น
            $table->decimal('work_hours', 5, 2)->nullable();

            // อัตราค่าจ้างต่อชั่วโมง
            $table->decimal('hourly_rate', 8, 2)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('works');
    }
};
