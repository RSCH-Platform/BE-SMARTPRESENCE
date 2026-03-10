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
        Schema::create('meeting_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_id')->constrained('meetings');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('assigned_by')->constrained('users');
            $table->timestamp('created_at')->useCurrent();

            $table->unique(['meeting_id','user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_assignments');
    }
};