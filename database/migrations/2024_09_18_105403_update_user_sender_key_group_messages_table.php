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
        Schema::table("group_messages", function (Blueprint $table) {
            $table->foreignUuid('group_id')->constrained()->onDelete('cascade')->change();
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
