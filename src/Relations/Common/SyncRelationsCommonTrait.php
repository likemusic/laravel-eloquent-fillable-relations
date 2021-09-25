<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\Common;

trait SyncRelationsCommonTrait
{
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