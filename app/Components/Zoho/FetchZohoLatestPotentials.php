<?php

namespace App\Components\Zoho;

use App\Events\Zoho\LatestPotentialsFetched;
use Carbon\Carbon;
use Illuminate\Console\Command;
use CristianPontes\ZohoCRMClient\ZohoCRMClient;

class FetchZohoLatestPotentials extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'dashboard:zoho-latest-potentials';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch latest potentials from Zoho CRM.';

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
            ->where('Stage', '-None-')
            ->orWhere('Stage', 'Qualification')
            ->orWhere('Stage', 'Needs analysis')
            ->orWhere('Stage', 'Requirement specification')
            ->orWhere('Stage', 'Negotiation')
            ->fromIndex(0)
            ->toIndex(40)
            ->request();

        $items = collect($records)
            ->sortByDesc(function($item){
                return $item->data["Created Time"];
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
            ->slice(0,7)
            ->values()
            ->toArray();

        event(new LatestPotentialsFetched($items));
    }
}