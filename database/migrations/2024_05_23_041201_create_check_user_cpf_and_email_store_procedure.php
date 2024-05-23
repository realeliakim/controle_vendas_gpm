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
        $store_procedure = "DROP PROCEDURE IF EXISTS `check_user_cpf_and_email`;
            CREATE PROCEDURE `check_user_cpf_and_email` (
                IN userCpf VARCHAR(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
                IN userEmail VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci)
            BEGIN
                SELECT * FROM users
                    WHERE email = userEmail OR cpf = userCpf;
            END;";
        DB::unprepared($store_procedure);
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $store_procedure = "DROP PROCEDURE IF EXISTS `check_user_cpf_and_email`";
        DB::unprepared($store_procedure);
    }
};
