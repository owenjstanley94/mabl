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
            $table->enum('role', ['referee', 'table'])->default('referee')->change();
        });
        // Set all existing entries to 'referee'
        DB::table('officials')->update(['role' => 'referee']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('officials', function (Blueprint $table) {
            $table->string('role')->nullable()->change();
        });
    }
};
