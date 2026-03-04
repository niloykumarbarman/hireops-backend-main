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
    Schema::create('resumes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('candidate_id')->constrained()->onDelete('cascade');
        $table->string('file_path');          // স্টোরেজ পাথ
        $table->string('original_name');      // আসল ফাইল নাম
        $table->string('mime_type')->nullable();
        $table->unsignedBigInteger('file_size')->nullable(); // bytes-এ
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resumes');
    }
};
