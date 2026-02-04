<?php

namespace App\Console\Commands;

use App\Models\ApiClient;
use Illuminate\Console\Command;

class AddAPIClient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api-client:add {name} {api-key-id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new API Client';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');

        $apiKeyId = $this->argument('api-key-id');

        if (ApiClient::where('api_key_id', $apiKeyId)->exists()) {

            $this->error("El ID de la API Key ya existe");

            exit;
        }

        $apiKey = bin2hex(random_bytes(32));

        $secretKey = bin2hex(random_bytes(32));

        ApiClient::create([
            'name' => $name,
            'api_key_id' => $apiKeyId,
            'api_key_hash' => hash_hmac('sha256', $apiKey, config('app.key')),
            'api_secret' => $secretKey,
        ]);

        $this->info("API Key: {$apiKey}");

        $this->info("Secret Key: {$secretKey}");
    }
}
