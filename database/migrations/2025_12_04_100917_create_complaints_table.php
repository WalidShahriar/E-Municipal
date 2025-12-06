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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('complaint_id')->unique(); // The COMP-YYYY-#### ID
            $table->string('title', 255);
            $table->string('category', 50);
            $table->text('description');
            $table->string('location')->nullable();
            $table->string('attachment_name')->nullable();
            $table->string('department', 100);
            $table->string('status')->default('Pending'); // Initial status
            $table->timestamps(); // Created at & Updated at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};