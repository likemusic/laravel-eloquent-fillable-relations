<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\HasOneOrMany;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany as BaseHasMany;
use Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\Common\UpdateCollectionByAttributesTrait;

class HasMany extends BaseHasMany
{
    use HasOneOrManyTrait, UpdateCollectionByAttributesTrait;

    public function updateByAttributes(?array $collectionAttributes, Collection $oldRelationValue)
    {
        return $this->updateCollectionByAttributes($collectionAttributes, $oldRelationValue);
    }
}
