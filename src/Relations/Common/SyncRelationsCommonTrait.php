<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\Common;

use Illuminate\Database\Eloquent\Relations\Relation;

trait SyncRelationsCommonTrait
{
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

    protected function beforeSyncRelations(): bool
    {
        return true;
    }

    protected function afterSyncRelations(): bool
    {
        return true;
    }

    protected function beforeSaveRelations()
    {
        return true;
    }

    protected function afterSaveRelations()
    {
        return true;
    }

    protected function beforeSaveRelation(string $relationName, $relationValue)
    {
        return true;
    }

    protected function afterSaveRelation(string $relationName, $relationValue)
    {
        return true;
    }
}
