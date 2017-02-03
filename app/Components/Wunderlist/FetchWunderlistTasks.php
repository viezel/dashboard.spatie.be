<?php

namespace App\Components\Wunderlist;

use App\Events\Wunderlist\TaskFetched;
use Illuminate\Console\Command;
use GuzzleHttp\Client;

class FetchWunderlistTasks extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'dashboard:wunderlist';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch tasks from a Wunderlist list.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = new Client();

        $response = $client->get('https://a.wunderlist.com/api/v1/tasks?list_id=' . env('WUNDERLIST_LIST_ID'), [
            'headers' => [
                'X-Access-Token' => env("WUNDERLIST_ACCESS_TOKEN"),
                'X-Client-ID' => env("WUNDERLIST_CLIENT_ID"),
                'Content-Type' => 'application/json'
            ]
        ])->getBody();

        $items = collect(json_decode($response))
            ->map(function($task){
                return [
                    'title' => $task->title,
                    'starred' => $task->starred
                ];
            })
            ->toArray();

        event(new TaskFetched($items));
    }
}