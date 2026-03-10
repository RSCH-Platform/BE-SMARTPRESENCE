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
        Schema::create('meeting_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_id')->constrained('meetings');

            $table->string('type',20);
            $table->string('file_name');
            $table->string('file_path',500);
            $table->integer('file_size');
            $table->string('mime_type',100);

            $table->string('director_name',150)->nullable();
            $table->string('director_position',150)->nullable();
            $table->dateTime('director_signed_at')->nullable();

            $table->string('notulis_name',150)->nullable();
            $table->string('notulis_position',150)->nullable();
            $table->dateTime('notulis_signed_at')->nullable();

            $table->foreignId('uploaded_by')->constrained('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_documents');
    }
};