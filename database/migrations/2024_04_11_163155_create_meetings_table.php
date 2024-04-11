<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique('meeting_unique_ix');
            $table->date('date');
            $table->string('description')->nullable();
            $table->uuid('responsible_id')->nullable();
            $table->foreign('responsible_id')->references('uuid')->on('responsibles');
            $table->uuid('period_id')->nullable();
            $table->foreign('period_id')->references('uuid')->on('periods');
            $table->uuid('local_id')->nullable();
            $table->foreign('local_id')->references('uuid')->on('locals');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
