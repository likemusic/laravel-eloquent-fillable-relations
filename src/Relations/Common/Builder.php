<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\Common;

use Illuminate\Database\Eloquent\Builder as LaravelBuilder;
use Illuminate\Database\Eloquent\Model;

class Builder extends LaravelBuilder
{
    public function createWithRelationsOrFail(array $attributes = []): Model
    {
        return tap($this->newModelInstance($attributes), function ($instance) {
            return $instance->pushOrFail();
        });
    }

    public function createWithRelations(array $attributes)
    {
        return tap($this->newModelInstance($attributes), function ($instance) {
            return $instance->push();
        });
    }
}
