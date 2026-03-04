<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('DROP PROCEDURE IF EXISTS sp_getBoekingenCount');

        DB::statement("
            CREATE PROCEDURE sp_getBoekingenCount()
            BEGIN
                SELECT COUNT(*) AS count
                FROM Boeking
                WHERE Boekingsstatus = 'Bevestigd';
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
