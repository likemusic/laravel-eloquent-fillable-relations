<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\HasOneOrMany;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasOne as BaseHasOne;
use Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\HasOneOrMany\HasOneOrManyTrait;
use Illuminate\Database\Eloquent\Model;

class HasOne extends BaseHasOne
{
    use HasOneOrManyTrait;

    public function updateByAttributes(?array $attributes, ?Model $oldRelationValue)
    {
        $updatedModel = $deletedId = null;

        if (($attributes === null) && $oldRelationValue) {
            $deletedId = $oldRelationValue->getKey();
        } else {
            $updatedModel = $oldRelationValue ?: $this->make();
            $updatedModel->fill($attributes);
        }

        return [$updatedModel, $deletedId];
    }
}
