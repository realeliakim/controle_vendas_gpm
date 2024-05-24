<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $trigger = "CREATE TRIGGER `check_stock_order`
        BEFORE INSERT ON `order_products` FOR EACH ROW
        BEGIN
            IF NEW.qnty_saled < 1 THEN
                SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Quantidade de estoque deve ser maior que 1';
            END IF;
        END;";

        DB::unprepared($trigger);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $trigger = "DROP TRIGGER CHECK_STOCK_ORDER";
        DB::unprepared($trigger);
    }
};
