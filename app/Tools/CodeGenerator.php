<?php

namespace App\Tools;

use Illuminate\Support\Facades\DB;

class CodeGenerator
{
    public static function generateCodeBySequence(string $prefix = 'EVT', int $numLength = 3, string $sequence = 'event_number_seq'): string
    {
        $row = DB::selectOne("SELECT nextval('$sequence') AS num");
        $num = $row->num;
        $year = date('Y');
        $numFormatted = str_pad($num, $numLength, '0', STR_PAD_LEFT);
        return "{$prefix}-{$year}-{$numFormatted}";
    }
}
