<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('generate:api-key', function () {

    $apiKey = bin2hex(random_bytes(32)); // 32 bytes → 64 caracteres hex

    $this->comment($apiKey);
})->purpose('Generate random api key string');