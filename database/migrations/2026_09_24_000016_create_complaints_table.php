<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('complaint_number')->unique();
            $table->foreignId('complaint_category_id')->constrained('complaint_categories');
            $table->foreignId('reporter_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('reporter_name');
            $table->string('reporter_phone');
            $table->text('location_detail');
            $table->foreignId('village_id')->constrained('villages');
            $table->text('description');
            $table->timestampTz('reported_at');
            $table->foreignId('officer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('status')->default('received');
            $table->text('verification_result')->nullable();
            $table->text('action_taken')->nullable();
            $table->foreignId('duplicate_of_id')->nullable()->constrained('complaints')->nullOnDelete();
            $table->timestampTz('resolved_at')->nullable();
            $table->timestampsTz();
            $table->softDeletesTz();

            $table->index('status');
            $table->index('village_id');
            $table->index('reported_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
