<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->uuid("sender_id")->change();
            $table->uuid("receiver_id")->change();
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade')->change();
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade')->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            //
        });
    }
};
