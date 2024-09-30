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
        Schema::create('organization_two_person_media', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string("filename");
            $table->string("file_path");
            $table->foreignUuid('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignUuid('receiver_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignUuid('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_two_person_media');
    }
};
