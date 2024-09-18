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
        Schema::create('groups', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid("sender_id");
            $table->uuid("receiver_id");
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
            $table->json("receiver_id")->nullable();
            $table->text("message");
            $table->boolean("isUpdate")->default(false);
            $table->boolean('isDelete')->default(false);
            $table->dateTime("deletedAt")->nullable();
            $table->enum('type', ['group']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
