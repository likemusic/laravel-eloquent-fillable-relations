<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\Common;

use Illuminate\Database\Eloquent\Collection;

trait PushOrFailTrait
{
    private $deletedRelations = [];

    public function pushOrFail()
    {
//        return $this->getConnection()->transaction(function () {
            $this->saveOrFail();
            $this->syncRelations();

            return $this;
//        });
    }

    private function syncRelations()
    {
        $this->beforeSyncRelations();

        $this->saveRelations();
        $this->deleteDeletedRelations();

        $this->afterSyncRelations();
    }

    protected function beforeSyncRelations()
    {

    }

    protected function afterSyncRelations()
    {

    }

    private function saveRelations()
    {
        $this->beforeSaveRelations();

        // To sync all of the relationships to the database, we will simply spin through
        // the relationships and save each model via this "push" method, which allows
        // us to recurse into all of these nested relations for the model instance.
        foreach ($this->relations as $relationName => $models) {
            $this->saveRelation($relationName, $models);
        }

        $this->afterSaveRelations();

    }

    protected function beforeSaveRelations()
    {

    }

    protected function afterSaveRelations()
    {

    }

    /**
     * @param $relationValue
     */
    private function saveRelation(string $relationName, $relationValue): void
    {
        $this->beforeSaveRelation($relationName, $relationValue);

        $relationValue = $relationValue instanceof Collection
            ? $relationValue->all() : [$relationValue];

        foreach (array_filter($relationValue) as $model) {
            $model->pushOrFail();
        }

        $this->afterSaveRelation($relationName, $relationValue);
    }

    protected function beforeSaveRelation(string $relationName, $models)
    {

    }

    protected function afterSaveRelation(string $relationName, $models)
    {

    }

    private function deleteDeletedRelations()
    {
        $deletedRelations = $this->deletedRelations;

        foreach ($deletedRelations as $relationName => $relationIds) {
            if (!$relationIds) {
                continue;
            }

            /** @var \Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\HasOneOrMany\HasMany $relation */
            $relation = $this->$relationName();
            $relation->getRelated()->destroy($relationIds);
        }
    }
}
