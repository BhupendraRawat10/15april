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
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
             $table->string('month'); // Format: YYYY-MM
            $table->integer('total_working_days');
            $table->integer('present_days');
            $table->integer('leaves');
            $table->integer('absents');
            $table->integer('half_days');
            $table->decimal('base_salary', 10, 2);
            $table->decimal('final_salary', 10, 2);
            $table->timestamps();
    
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salaries');
    }
};
