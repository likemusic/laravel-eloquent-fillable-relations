<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\Common;

use Illuminate\Database\Eloquent\Collection;
use Likemusic\LaravelFillableRelationsWithoutAutosave\Exception;

trait SyncRelationsOrFailTrait
{
    private function syncRelationsOrFail()
    {
        if (!$this->beforeSyncRelations()) {
            $this->throwExceptionForMethod('beforeSyncRelations');
        };

        $this->saveRelationsOrFail();

        $this->deleteDeletedRelations();

        if (!$this->afterSyncRelations()) {
            $this->throwExceptionForMethod('afterSyncRelations');
        }
    }

    private function throwExceptionForMethod(string $methodName)
    {
        $exceptionMessage = $this->getExceptionMessageByMethodName($methodName);

        throw new Exception($exceptionMessage);
    }

    private function getExceptionMessageByMethodName(string $methodName): string
    {
        return "\"$methodName\" return not true value.";
    }

    private function saveRelationsOrFail(): bool
    {
        if (!$this->beforeSaveRelations()) {
            $this->throwExceptionForMethod('beforeSaveRelations');
        };

        // To sync all of the relationships to the database, we will simply spin through
        // the relationships and save each model via this "push" method, which allows
        // us to recurse into all of these nested relations for the model instance.
        foreach ($this->relations as $relationName => $models) {
            $this->saveRelationOrFail($relationName, $models);
        }

        if (!$this->afterSaveRelations()) {
            $this->throwExceptionForMethod('afterSaveRelations');
        };

        return true;
    }

    private function saveRelationOrFail(string $relationName, $relationValue)
    {
        if (!$this->beforeSaveRelation($relationName, $relationValue)) {
            $this->throwExceptionForMethod('beforeSaveRelation');
        };

        $relationValue = $relationValue instanceof Collection
            ? $relationValue->all() : [$relationValue];

        foreach (array_filter($relationValue) as $model) {
            $model->pushOrFail();
        }

        if (!$this->afterSaveRelation($relationName, $relationValue)) {
            $this->throwExceptionForMethod('afterSaveRelation');
        }
    }
}
