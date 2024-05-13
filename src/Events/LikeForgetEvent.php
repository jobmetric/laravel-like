<?php

namespace JobMetric\Like\Events;

use JobMetric\Like\Models\Like;

class LikeForgetEvent
{
    public Like $model;

    /**
     * Create a new event instance.
     */
    public function __construct(Like $model)
    {
        $this->model = $model;
    }
}
