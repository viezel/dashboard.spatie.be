<?php

namespace App\Events\Relic;

use App\Events\DashboardEvent;

class RPMFetched extends DashboardEvent
{
    /** @var array */
    public $points;

    /** @var float */
    public $average;

    public function __construct(array $points, $average)
    {
        $this->points = $points;
        $this->average = $average;
    }
}
