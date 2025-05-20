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
        DB::statement("ALTER TABLE officials ADD CONSTRAINT role_check_lower CHECK (role IN ('Referee', 'Table'))");
        // Set all existing entries to 'Referee'
        DB::table('officials')->update(['role' => 'Referee']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop check constraint
        DB::statement("ALTER TABLE officials DROP CONSTRAINT IF EXISTS role_check_lower");
        // Change type back to varchar(255)
        DB::statement("ALTER TABLE officials ALTER COLUMN role TYPE varchar(255)");
        // Drop default
        DB::statement("ALTER TABLE officials ALTER COLUMN role DROP DEFAULT");
        // Drop NOT NULL
        DB::statement("ALTER TABLE officials ALTER COLUMN role DROP NOT NULL");
    }
};
