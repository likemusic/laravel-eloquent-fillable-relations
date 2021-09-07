<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\Common;

use Illuminate\Database\Eloquent\Collection;

trait UpdateCollectionByAttributesTrait
{
    protected function updateCollectionByAttributes(?array $collectionAttributes, Collection $oldRelationValue)
    {
        $keyName = $this->related->getKeyName();

        $byKeyIndexedOldRelationValue = $oldRelationValue->keyBy($keyName);

        $updatedCollection = $this->related->newCollection();

        foreach ($collectionAttributes as $modelAttributes) {
            if (!empty($modelAttributes[$keyName])) {
                $keyValue = $modelAttributes[$keyName];
                $oldModel = $byKeyIndexedOldRelationValue[$keyValue];

                $oldModel->fill($modelAttributes);
                $updatedModel = $oldModel;
            } else {
                $updatedModel = $this->make($modelAttributes);
            }

            $updatedCollection->add($updatedModel);
        }

        $updatedIds = array_map(function ($attributes) use ($keyName) {
            return !empty($attributes[$keyName]) ? $attributes[$keyName] : null;
        }, $collectionAttributes);

        $updatedIds = array_filter($updatedIds);

        $oldIds = $byKeyIndexedOldRelationValue->keys()->toArray();

        $deletedIds = array_diff($oldIds, $updatedIds);

        return [$updatedCollection, $deletedIds];
    }

}