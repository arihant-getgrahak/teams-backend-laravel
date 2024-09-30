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
        Schema::create('organization_group_media', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string("filename");
            $table->string("file_path");
            $table->foreignUuid('organization_group_id')->references('id')->on('organization_groups')->onDelete('cascade');
            $table->foreignUuid('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->foreignUuid('senders_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_group_media');
    }
};
