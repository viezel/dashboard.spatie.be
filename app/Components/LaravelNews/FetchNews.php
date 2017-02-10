<?php

namespace App\Components\LaravelNews;

use App\Events\LaravelNews\NewsFetched;
use Carbon\Carbon;
use Illuminate\Console\Command;
use GuzzleHttp\Client;

class FetchNews extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'dashboard:laravelnews';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch news from Laravel News.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $client = new Client();

        $response = $client->get('https://feed.laravel-news.com', [
            'headers' => [
                'Content-Type' => 'application/xml'
            ]
        ])->getBody();

        $feed = new \DOMDocument();
        $feed->loadXML($response);
        $rawItems = $feed->getElementsByTagName('channel')->item(0)->getElementsByTagName('item');

        $newsItems = collect();

        foreach($rawItems as $key => $item) {
            $title = $item->getElementsByTagName('title')->item(0)->firstChild->nodeValue;
            $description = $item->getElementsByTagName('description')->item(0)->firstChild->nodeValue;
            $pubDate = $item->getElementsByTagName('pubDate')->item(0)->firstChild->nodeValue;
            $guid = $item->getElementsByTagName('guid')->item(0)->firstChild->nodeValue;

            preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $description, $img);
            preg_match('/<p>(.*?)<\/p>/i', $description, $smallDescription);
            $newsItems->push([
                'title' => $title,
                'description' => str_limit(strip_tags($smallDescription[1]), 100),
                'date' => Carbon::createFromFormat('D, d M Y H:i:s O',$pubDate)->format('j. F'),
                'guid' => $guid,
                'image' => $img[1]
            ]);
        }

        event(new NewsFetched($newsItems->take(4)->toArray()));
    }
}