<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\Common;

use Illuminate\Database\Eloquent\Builder as LaravelBuilder;
use Illuminate\Database\Eloquent\Model;

class Builder extends LaravelBuilder
{
    public function createWithRelations(array $attributes = []): Model
    {
        return $this->getConnection()->transaction(function () use ($attributes) {
            $model = $this->create($attributes);
            $model->pushOrFail();

            return $model;
        });
    }
}
