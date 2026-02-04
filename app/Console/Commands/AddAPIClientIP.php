<?php

namespace App\Console\Commands;

use App\Models\ApiClient;
use App\Models\ApiClientIp;
use Illuminate\Console\Command;

class AddAPIClientIP extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api-client:auth-ip {api-client-id} {ip} {description?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Authorized IP address for an api key';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $api_client_id = $this->argument('api-client-id');

        $ip = $this->argument('ip');

        $description = $this->argument('description') ?? null;

        if (!ApiClient::where('id', $api_client_id)->exists()) {

            $this->error("No existe el api client id $api_client_id");

            return Command::FAILURE;
        }

        if (! filter_var($ip, FILTER_VALIDATE_IP)) {

            $this->error("IP inválida $ip");

            return Command::FAILURE;
        }

        if (ApiClientIp::where('api_client_id', $api_client_id)->where('ip', $ip)->exists()) {

            $this->error("Ya existe el registro para el api client id y direccion IP");

            return Command::FAILURE;
        }

        ApiClientIp::create([
            'api_client_id' => $api_client_id,
            'ip' => $ip,
            'description' => $description,
        ]);
    }
}
