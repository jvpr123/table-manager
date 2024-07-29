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
        Schema::create('meeting_group_locals', function (Blueprint $table) {
            $table->foreignUuid('meeting_group_id')->constrained(
                table: 'meeting_groups',
                column: 'uuid'
            );
            $table->foreignUuid('local_id')->constrained(
                table: 'locals',
                column: 'uuid'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_group_locals');
    }
};
