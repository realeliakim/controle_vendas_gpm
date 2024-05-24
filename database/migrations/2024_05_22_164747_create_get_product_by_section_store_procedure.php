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
        $store_procedure = "DROP PROCEDURE IF EXISTS `get_product_by_section`;
            CREATE PROCEDURE `get_product_by_section` (IN id int)
            BEGIN
                IF id = 1 THEN
                    SELECT * FROM products WHERE available = true;
                ELSE
                    SELECT * FROM products WHERE section_id = id AND available = true;
                END IF;
            END;";
        DB::unprepared($store_procedure);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $store_procedure = "DROP PROCEDURE IF EXISTS `get_product_by_section`";
        DB::unprepared($store_procedure);
    }
};
