<?php

namespace JobMetric\Like\Events;

use JobMetric\Like\Models\Like;

class LikeUpdateEvent
{
    public Like $model;
    public bool $type;

    /**
     * Create a new event instance.
     */
    public function __construct(Like $model, bool $type)
    {
        $this->model = $model;
        $this->type = $type;
    }
}
