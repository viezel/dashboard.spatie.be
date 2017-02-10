<?php

namespace App\Components\Relic;

use App\Events\Relic\RPMFetched;
use Carbon\Carbon;
use Illuminate\Console\Command;
use GuzzleHttp\Client;

class FetchNewRelicRPM extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'dashboard:newrelic-rpm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch the app RPM from New Relic.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = new Client();

        $response = $client->get('https://api.newrelic.com/v2/applications/'.env('NEW_RELIC_APP_ID').'/metrics/data.json', [
            'query' => [
                'names[]' => 'HttpDispatcher',
                'values[]' => 'requests_per_minute'
            ],
            'headers' => [
                'X-Api-Key' => env("NEW_RELIC_API_KEY"),
                'Content-Type' => 'application/json'
            ]
        ])->getBody();

        $avg = 0;
        $list = json_decode($response)->metric_data->metrics[0]->timeslices;

        $serverList = collect($list)
            ->map(function($server) use (&$avg){
                $avg = $avg + $server->values->requests_per_minute;
                return [
                    'label' => Carbon::parse($server->to)->format("H:i"),
                    'value' => $server->values->requests_per_minute,
                ];
            })
            ->toArray();

        $avg = number_format($avg / count($list), 1);

        event(new RPMFetched($serverList, $avg));
    }
}