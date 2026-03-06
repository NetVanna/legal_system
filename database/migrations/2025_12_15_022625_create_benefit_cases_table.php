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
        Schema::create('benefit_cases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('case_id')->constrained('cases')->onDelete('cascade');
            $table->string('client_name');
            $table->string('type_case');
            $table->date('date');
            $table->string('chapter')->nullable();
            $table->string('sub_chapter')->nullable();
            $table->decimal('service_fee', 10, 2)->default(0);
            $table->string('employee');
            $table->decimal('employee_fee', 10, 2)->default(0);
            $table->decimal('chapter_fee', 10, 2)->default(0);
            $table->decimal('admin_fee', 10, 2)->default(0);
            $table->decimal('it_fee', 10, 2)->default(0);
            $table->string('lawyer');
            $table->decimal('lawyer_fee', 10, 2)->default(0);
            $table->decimal('net_fee', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('benefit_cases');
    }
};
