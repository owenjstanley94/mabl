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
        Schema::create('fixtures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('league_id')->constrained('leagues')->onDelete('cascade');
            $table->foreignId('home_team_id')->constrained('teams')->onDelete('cascade');
            $table->foreignId('away_team_id')->constrained('teams')->onDelete('cascade');
            $table->foreignId('crew_chief_id')->nullable()->constrained('officials')->onDelete('set null');
            $table->foreignId('referee_1_id')->nullable()->constrained('officials')->onDelete('set null');
            $table->foreignId('referee_2_id')->nullable()->constrained('officials')->onDelete('set null');
            $table->date('date')->required();
            $table->unsignedSmallInteger('home_team_score')->nullable();
            $table->unsignedSmallInteger('away_team_score')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixtures');
    }
};
