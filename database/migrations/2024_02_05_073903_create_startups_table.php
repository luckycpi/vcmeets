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
        Schema::create('startups', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('description');
            $table->string('sector');
            $table->string('founders')->nullable();
            $table->string('founders_nationality')->nullable();
            $table->string('team_size')->default(0);
            $table->string('headquarters')->nullable();
            $table->string('investment_stage')->nullable();
            $table->string('funds_raised')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('startups');
    }
};
