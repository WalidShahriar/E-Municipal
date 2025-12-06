<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
public function up()
{
    Schema::create('service_requests', function (Blueprint $table) {
        $table->id();
        $table->string('request_id')->unique();
        $table->string('title', 150);
        $table->string('category', 50);
        $table->text('description');
        $table->string('location')->nullable();
        $table->string('attachment_name')->nullable();
        $table->string('department', 100);
        $table->string('status', 50)->default('Requested');
        $table->text('manager_remarks')->nullable();
        $table->string('submitted_by')->nullable(); 
        $table->timestamps(); 
    });
}

    
    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};
