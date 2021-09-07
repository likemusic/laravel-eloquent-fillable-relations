<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\MorphOneOrMany;

use Illuminate\Database\Eloquent\Model;
use Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\Common\UpdateForeignKeyByRefTrait;

trait MorphOneOrManyTrait
{
    use UpdateForeignKeyByRefTrait;

    /**
     * Set the foreign ID and type for creating a related model.
     *
     * @param Model $model
     * @return void
     */
    protected function setForeignAttributesForCreate(Model $model)
    {
        $this->updateForeignKeyByRef($model);
        $model->{$this->getMorphType()} = $this->morphClass;
    }
}