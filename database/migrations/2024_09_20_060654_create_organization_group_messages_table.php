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
        Schema::create('organization_group_messages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('message');
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('organization_group_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_group_messages');
    }
};
