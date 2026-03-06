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
        Schema::create('cases', function (Blueprint $table) {
            $table->id();

            // Basic Case Info
            $table->string('case_number')->unique()->nullable();
            $table->string('case_title')->nullable();
            $table->string('case_type')->nullable();
            $table->text('description')->nullable();
            // Relations
            $table->foreignId('client_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('lawyer_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('instructor_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('chapter_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('subchapter_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('casecode_id')->nullable()->constrained()->onDelete('cascade');
            // People / JSON data
            $table->json('client_relative')->nullable();
            $table->json('opponents')->nullable();
            $table->json('case_data')->nullable();
            // Dates
            $table->date('filed_date')->nullable();
            $table->date('closed_date')->nullable();
            $table->dateTime('day_judge')->nullable();
            $table->dateTime('day_show')->nullable();

            // Finance
            $table->string('payment_type')->nullable();
            $table->decimal('case_price', 15, 2)->default(0);
            $table->string('discount')->nullable();
            $table->decimal('payment_amount', 15, 2)->default(0);

            // Status
            $table->enum('payment_status', ['unpaid', 'partial', 'paid'])->default('unpaid');
            $table->enum('case_status', ['open', 'in_progress', 'closed', 'won', 'lost', 'settled'])->default('open');

            // Outcome
            $table->text('outcome')->nullable();
            // documents
            $table->json('documents')->nullable();


            // Timestamps
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cases');
    }
};
