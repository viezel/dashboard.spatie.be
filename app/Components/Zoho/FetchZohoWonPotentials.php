<?php

namespace App\Components\Zoho;

use App\Events\Zoho\WonPotentialsFetched;
use Carbon\Carbon;
use Illuminate\Console\Command;
use CristianPontes\ZohoCRMClient\ZohoCRMClient;

class FetchZohoWonPotentials extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'dashboard:zoho-won-potentials';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch won potentials from Zoho CRM.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $client = new ZohoCRMClient('Potentials', env('ZOHO_TOKEN'));

        $records = $client->searchRecords()
            ->selectColumns(['Created Time', 'Potential Name', 'Account Name', 'Probability', 'Closing Date', 'Potential Owner', 'Amount', 'Stage'])
            ->where('Stage', 'Closed Won')
            ->fromIndex(0)
            ->toIndex(40)
            ->request();

        $items = collect($records)

            // no older than 30 days
            ->reject(function($item){
                return Carbon::createFromFormat("Y-m-d",$item->data["Closing Date"])->diffInDays() > 30;
            })

            // sort by closing date
            ->sortByDesc(function($item){
                return $item->data["Closing Date"];
            })
            ->map(function($item){
                return [
                    'user' => explode(" ", $item->data["Potential Owner"])[0], // first name
                    'accountName' => $item->data["Account Name"], // first name
                    'amount' => number_format($item->data["Amount"],0,",","."),
                    'closingDate' => Carbon::createFromFormat("Y-m-d",$item->data["Closing Date"])->format("d. M"),
                    'probability' => $item->data["Probability"],
                ];
            })

            // max 7 results
            ->slice(0,7)
            // reindex
            ->values()
            ->toArray();

        event(new WonPotentialsFetched($items));
    }
}