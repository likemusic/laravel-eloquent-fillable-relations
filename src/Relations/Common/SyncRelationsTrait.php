<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\Common;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Relation;

trait SyncRelationsTrait
{
    use SyncRelationsCommonTrait;

    private function syncRelations(): bool
    {
        if (!$this->beforeSyncRelations()) {
            return false;
        };

        if (!$this->saveRelations()) {
            return false;
        }

        $this->deleteDeletedRelations();

        if (!$this->afterSyncRelations()) {
            return false;
        }

        return true;
    }


    private function saveRelations(): bool
    {
        if (!$this->beforeSaveRelations()) {
            return false;
        };

        // To sync all of the relationships to the database, we will simply spin through
        // the relationships and save each model via this "push" method, which allows
        // us to recurse into all of these nested relations for the model instance.
        foreach ($this->relations as $relationName => $models) {
            if (!$this->saveRelation($relationName, $models)) {
                return false;
            }
        }

        if (!$this->afterSaveRelations()) {
            return false;
        };

        return true;
    }

    private function saveRelation(string $relationName, $relationValue): bool
    {
        if (!$this->beforeSaveRelation($relationName, $relationValue)) {
            return false;
        };

        $relationValue = $relationValue instanceof Collection
            ? $relationValue->all() : [$relationValue];

        foreach (array_filter($relationValue) as $model) {
            if (!$model->push()) {
                return false;
            }
//            $model->pushOrFail();
        }

        if (!$this->afterSaveRelation($relationName, $relationValue)) {
            return false;
        }

        return true;
    }


    private function deleteDeletedRelations()
    {
        $deletedRelations = $this->deletedRelations;

        foreach ($deletedRelations as $relationName => $relationIds) {
            if (!$relationIds) {
                continue;
            }

            /** @var Relation $relation */
            $relation = $this->$relationName();
            $relation->getRelated()->destroy($relationIds);
        }
    }
}