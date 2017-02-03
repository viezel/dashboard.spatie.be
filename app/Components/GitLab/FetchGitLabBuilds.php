<?php

namespace App\Components\GitLab;

use App\Events\GitLab\BuildFetched;
use App\Events\Relic\ServerListFetched;
use Illuminate\Console\Command;
use GuzzleHttp\Client;

class FetchGitLabBuilds extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'dashboard:gitlab-builds';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch the builds from GitLab.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $projects = explode(',', env('GITLAB_PROJECTS'));
        $projectNames = explode(',', env('GITLAB_PROJECT_NAMES'));

        $builds = [];
        $index = 0;
        foreach($projects as $id ){
            $build = $this->getBuildByProject($id, $projectNames[$index]);

            if($build !== null){
                $builds[] = $build;
            }
            $index++;
        }

        event(new BuildFetched($builds));
    }

    /**
     * @param $id
     * @return array|null
     */
    private function getBuildByProject($id, $name)
    {
        $client = new Client();

        $response = $client->get(env('GITLAB_URL') . '/api/v3/projects/'. $id . '/pipelines?per_page=40', [
            'headers' => [
                'PRIVATE-TOKEN' => env("GITLAB_PRIVATE_TOKEN"),
                'Content-Type' => 'application/json'
            ]
        ])->getBody();

        $list = collect(json_decode($response));

        $develop = $list
            ->filter(function($build){
                return $build->ref == "develop";
            })
            ->map(function($build) use ($name) {
                return [
                    'project_name' => $name,
                    'date' => $build->finished_at,
                    'user' => $build->user->name,
                    'status' => $build->status,
                    'coverage' => round((float)$build->coverage)
                ];
            });

        if(!$develop->isEmpty()){
            return $develop->first();
        }

        return null;
    }
}