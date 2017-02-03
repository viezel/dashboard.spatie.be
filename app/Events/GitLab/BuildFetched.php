<?php

namespace App\Events\GitLab;

use App\Events\DashboardEvent;

class BuildFetched extends DashboardEvent
{
    /** @var array */
    public $builds;

    public function __construct(array $builds)
    {
        $this->builds = $builds;
    }
}
