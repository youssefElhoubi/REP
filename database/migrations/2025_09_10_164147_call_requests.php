<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('call_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('properties')->onDelete('cascade');
            $table->foreignId('requester_id')->constrained('users')->onDelete('cascade'); 
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade'); 
            $table->enum('status', ['pending', 'accepted', 'rejected', 'completed'])->default('pending');
            $table->integer('call_duration')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('call_requests');
    }
};
