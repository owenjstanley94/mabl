<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('officials', function (Blueprint $table) {
            $table->enum('role', ['Referee', 'Table'])->default('Referee')->change();
        });
        // Update all existing data to capitalized values
        DB::table('officials')->where('role', 'referee')->update(['role' => 'Referee']);
        DB::table('officials')->where('role', 'table')->update(['role' => 'Table']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('officials', function (Blueprint $table) {
            $table->enum('role', ['referee', 'table'])->default('referee')->change();
        });
        // Revert all existing data to lowercase values
        DB::table('officials')->where('role', 'Referee')->update(['role' => 'referee']);
        DB::table('officials')->where('role', 'Table')->update(['role' => 'table']);
    }
};
