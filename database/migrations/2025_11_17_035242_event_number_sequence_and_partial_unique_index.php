<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("CREATE SEQUENCE IF NOT EXISTS event_number_seq START 1;");

        $row = DB::selectOne("
            SELECT COALESCE(
                MAX( (regexp_replace(number, '.*-(\\d+)$', '\\1'))::bigint ),
                0
            ) AS maxnum
            FROM events
        ");

        $max = $row->maxnum ?? 0;

        // Jika max = 0, set sequence ke (1, false), supaya nextval() mengeluarkan 1
        if ($max == 0) {
            DB::statement("SELECT setval('event_number_seq', 1, false)");
        } else {
            DB::statement("SELECT setval('event_number_seq', {$max}, true)");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP SEQUENCE IF EXISTS event_number_seq;");
    }
};
