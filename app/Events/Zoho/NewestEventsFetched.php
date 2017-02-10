<?php

namespace App\Events\Zoho;

use App\Events\SalesDashboardEvent;

class NewestEventsFetched extends SalesDashboardEvent
{
    /** @var array */
    public $events;

    public function __construct(array $events)
    {
        $this->events = $events;
    }
}