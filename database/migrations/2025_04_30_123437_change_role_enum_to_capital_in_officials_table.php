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
        // Change type to varchar(255)
        DB::statement("ALTER TABLE officials ALTER COLUMN role TYPE varchar(255)");
        // Set default
        DB::statement("ALTER TABLE officials ALTER COLUMN role SET DEFAULT 'Referee'");
        // Set NOT NULL
        DB::statement("ALTER TABLE officials ALTER COLUMN role SET NOT NULL");
        // Add check constraint
        DB::statement("ALTER TABLE officials ADD CONSTRAINT role_check CHECK (role IN ('Referee', 'Table'))");
        // Update all existing data to capitalized values
        DB::table('officials')->where('role', 'referee')->update(['role' => 'Referee']);
        DB::table('officials')->where('role', 'table')->update(['role' => 'Table']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop check constraint
        DB::statement("ALTER TABLE officials DROP CONSTRAINT IF EXISTS role_check");
        // Change type back to varchar(255)
        DB::statement("ALTER TABLE officials ALTER COLUMN role TYPE varchar(255)");
        // Set default
        DB::statement("ALTER TABLE officials ALTER COLUMN role SET DEFAULT 'referee'");
        // Set NOT NULL
        DB::statement("ALTER TABLE officials ALTER COLUMN role SET NOT NULL");
        // Revert all existing data to lowercase values
        DB::table('officials')->where('role', 'Referee')->update(['role' => 'referee']);
        DB::table('officials')->where('role', 'Table')->update(['role' => 'table']);
    }
};
