<?php

namespace App\Events\Wunderlist;

use App\Events\DashboardEvent;

class TaskFetched extends DashboardEvent
{
    /** @var array */
    public $tasks;

    public function __construct(array $tasks)
    {
        $this->tasks = $tasks;
    }
}