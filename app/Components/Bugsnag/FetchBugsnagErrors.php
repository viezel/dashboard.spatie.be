<?php

namespace App\Components\Bugsnag;

use App\Events\Bugsnag\ErrorFetched;
use Carbon\Carbon;
use Illuminate\Console\Command;
use GuzzleHttp\Client;

class FetchBugsnagErrors extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'dashboard:bugsnag';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch errors from Bugsnag.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = new Client();

        $response = $client->get('https://api.bugsnag.com/projects/'.env("BUGSNAG_PROJECT_ID").'/errors?status=open&auth_token='. env("BUGSNAG_API_TOKEN"), [
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ])->getBody();

        // only keep servers with summary and remap it
        $errors = collect(json_decode($response))
            ->map(function($error){
                return [
                    'class' => $error->class,
                    'last_message' => $error->last_message,
                    'occurrences' => $error->occurrences,
                    'last_context' => $error->last_context,
                    'last_received' => Carbon::parse($error->last_received)->diffForHumans()
                ];
            })
            ->toArray();

        event(new ErrorFetched($errors));
    }
}