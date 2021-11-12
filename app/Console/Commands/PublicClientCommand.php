<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Laravel\Passport\Client;
use Laravel\Passport\ClientRepository;

class PublicClientCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'passport:public
            {--name= : The name of the client.}
            {--redirect_uri= : The URI to redirect to after authorization.}
            {--initial_client : Only run the command if a public client does not already exist.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a public client for issuing access tokens';

    /**
     * Execute the console command.
     *
     * @param  ClientRepository  $clients
     * @return void
     */
    public function handle(ClientRepository $clients): void
    {
        $this->createPublicClient($clients);
    }

    /**
     * Create a new public client.
     *
     * @param  ClientRepository  $clients
     * @return void
     */
    protected function createPublicClient(ClientRepository $clients): void
    {
        $name = config('app.name').' Public Client';
        $redirect = url('http://localhost:8080/login/');

        if (!$this->option('initial_client')) {
            $name = $this->option('name') ?: $this->ask(
                'What should we name the public client?',
                $name
            );

            $redirect = $this->option('redirect_uri') ?: $this->ask(
                'Where should we redirect the request after authorization?',
                $redirect
            );
        }

        $public_clients = Client::where([
            ['user_id', '=', null],
            ['secret', '=', null],
            ['personal_access_client', '=', false],
            ['password_client', '=', false],
            ['revoked', '=', false],
        ])->get();

        $count = count($public_clients);

        if (0 < $count && $this->option('initial_client')) {
            $this->info('Public client already exists.');
        } else {
            $client = $clients->create(
                null, $name, $redirect, false, false, false
            );

            $this->info('Public client created successfully.');

            $this->outputClientDetails($client);
        }
    }

    /**
     * Output the client's ID and secret key.
     *
     * @param  Client  $client
     * @return void
     */
    protected function outputClientDetails(Client $client): void
    {
        $this->line('<comment>Client ID:</comment> '.$client->id);
    }
}
