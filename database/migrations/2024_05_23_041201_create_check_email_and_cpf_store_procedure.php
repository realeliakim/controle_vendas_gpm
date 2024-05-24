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
        $store_procedure = "DROP PROCEDURE IF EXISTS `check_user_email_and_cpf`;
            CREATE PROCEDURE `check_user_email_and_cpf` (
                IN var_email VARCHAR(100),
                IN var_cpf VARCHAR(50))
            BEGIN
                SELECT * FROM `users` WHERE `email` = var_email OR `cpf` = var_cpf;
            END;";
        DB::unprepared($store_procedure);
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $store_procedure = "DROP PROCEDURE IF EXISTS `check_user_email_and_cpf`";
        DB::unprepared($store_procedure);
    }
};
