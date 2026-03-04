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
        Schema::create('company_costs', function (Blueprint $table) {
            

        $table->id();

        $table->foreignId('company_id')
              ->constrained()
              ->onDelete('cascade');

        $table->decimal('amount', 10, 2);

        $table->string('title');

        $table->text('description')->nullable();

        $table->date('cost_date');

        $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_costs');
    }
};
