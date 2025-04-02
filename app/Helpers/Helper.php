<?php

namespace App\Helpers;

use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;

class Helper
{
    public static function extractError($e): string
    {
        return 'message : ' . $e->getMessage() . ' at line : ' . $e->getLine() . ' in : ' . $e->getFile();
    }

    public static function timestampToDateTime(string $timestamp): string
    {
        return Carbon::createFromTimestamp($timestamp)->toDateTimeString();
    }

    public static function gregorianToShamsi(string $gregorianDate, bool $hasTime = false): string
    {
        $date = Carbon::parse($gregorianDate);
        $verta = Verta::instance($date);
        $format = $hasTime ? 'Y/m/d H:i:s' : 'Y/m/d';

        return $verta->format($format);
    }

    public static function generateUniqueCode($prefix = 'PAY'): string
    {
        $randomNumber = rand(10000, 99999);
        $randomLetters = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3));

        return "{$prefix}-{$randomNumber}{$randomLetters}";
    }

    public static function generateImageUrl($path): string
    {
        return asset('storage' . $path);
    }

    public static function generateFileUrl($path): string
    {
        return asset($path);
    }
}
