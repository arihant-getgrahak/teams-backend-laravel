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
        Schema::table('invite_users', function (Blueprint $table) {
            $table->foreignUuid("invitedBy");
            $table->foreignUuid("invitedTo");
            $table->foreignUuid("organization_id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invite', function (Blueprint $table) {
            //
        });
    }
};
