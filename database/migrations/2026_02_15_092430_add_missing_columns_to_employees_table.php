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
    Schema::table('employees', function (Blueprint $table) {
        if (!Schema::hasColumn('employees', 'name')) {
            $table->string('name')->after('id');
        }
        if (!Schema::hasColumn('employees', 'email')) {
            $table->string('email')->nullable()->unique()->after('name');
        }
        if (!Schema::hasColumn('employees', 'phone')) {
            $table->string('phone')->nullable()->after('email');
        }
        if (!Schema::hasColumn('employees', 'position')) {
            $table->string('position')->nullable()->after('phone');
        }
        if (!Schema::hasColumn('employees', 'salary')) {
            $table->decimal('salary', 10, 2)->nullable()->after('position');
        }
        if (!Schema::hasColumn('employees', 'company_id')) {
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade')->after('salary');
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
        $table->dropColumn(['name', 'email', 'phone', 'position', 'salary', 'company_id']);
    });
    }
};
