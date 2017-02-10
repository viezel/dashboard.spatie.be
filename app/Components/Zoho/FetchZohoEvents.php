<?php

namespace App\Components\Zoho;

use App\Events\Zoho\NewestEventsFetched;
use App\Events\Zoho\SummaryEventsFetched;
use Carbon\Carbon;
use Illuminate\Console\Command;
use CristianPontes\ZohoCRMClient\ZohoCRMClient;
use Illuminate\Support\Collection;

class FetchZohoEvents extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'dashboard:zoho-events';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch events from Zoho CRM.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $client = new ZohoCRMClient('Events', env('ZOHO_TOKEN'));

        $records = $client->getRecords()
            ->selectColumns(['Created Time', 'Start DateTime', 'Subject', 'Event Owner', 'Event Type'])
            ->sortBy('Created Time')->sortDesc()
            ->since(date_create('this week'))
            ->request();

        // Summary list
        $summary = collect($records)
            ->map(function($item){
                return [
                    'user' => $item->data["Event Owner"],
                    'type' => $item->data["Event Type"] ?? "unknown"
                ];
            })
            ->groupBy("user")
            ->map(function($salesPerson){
                /** @var Collection $salesPerson */
                return [
                    'user' => $name = $salesPerson->first()["user"],
                    'total' =>$salesPerson->count(),
                    'siesta' => $salesPerson->where("type", "Siesta")->count(),
                    'partner' => $salesPerson->where("type", "Partner - Reseller")->count()
                ];
            })
            ->toArray();

        event(new SummaryEventsFetched($summary));


        // event list
        $items = collect($records)
            ->map(function($item){
                return [
                    'user' => explode(" ", $item->data["Event Owner"])[0], // first name
                    'subject' => $item->data["Subject"],
                    'eventDate' => Carbon::createFromFormat("Y-m-d H:i:s",$item->data["Start DateTime"])->format("d. M"),
                ];
            })
            ->toArray();

        event(new NewestEventsFetched($items));
    }
}