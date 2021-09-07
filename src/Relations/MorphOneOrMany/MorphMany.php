<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\MorphOneOrMany;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany as BaseMorphMany;
use Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\Common\UpdateCollectionByAttributesTrait;

class MorphMany extends BaseMorphMany
{
    use MorphOneOrManyTrait, UpdateCollectionByAttributesTrait;

    public function updateByAttributes(?array $collectionAttributes, Collection $oldRelationValue)
    {
        return $this->updateCollectionByAttributes($collectionAttributes, $oldRelationValue);
    }
}
