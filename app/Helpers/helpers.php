<?php

use Carbon\CarbonInterval;

if (!function_exists('http_message')) {
    function http_message(int $code, array $replacements = []): string
    {
        return __("http.$code", $replacements);
    }
}

if (! function_exists('humanize_seconds')) {
    function humanize_seconds(?int $seconds): ?string
    {
        if (is_null($seconds)) {
            return null;
        }

        $interval = CarbonInterval::seconds($seconds)->cascade();

        return $interval->forHumans();
    }
}