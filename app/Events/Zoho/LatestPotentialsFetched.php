<?php

namespace App\Events\Zoho;

use App\Events\SalesDashboardEvent;

class LatestPotentialsFetched extends SalesDashboardEvent
{
    /** @var array */
    public $potentials;

    public function __construct(array $potentials)
    {
        $this->potentials = $potentials;
    }
}