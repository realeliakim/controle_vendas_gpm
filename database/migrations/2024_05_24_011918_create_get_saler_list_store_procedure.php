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
        $store_procedure = "DROP PROCEDURE IF EXISTS `get_saler_list`;
            CREATE PROCEDURE `get_saler_list` ()
            BEGIN
                SELECT * FROM users WHERE user_type_id != 3;
            END;";
        DB::unprepared($store_procedure);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $store_procedure = "DROP PROCEDURE IF EXISTS `get_saler_list`";
        DB::unprepared($store_procedure);
    }
};
