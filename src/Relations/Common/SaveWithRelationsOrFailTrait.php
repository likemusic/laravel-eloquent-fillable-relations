<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\Common;

use Illuminate\Database\Eloquent\Collection;
use Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\HasMany;

trait SaveWithRelationsOrFailTrait
{
    private $deletedRelations = [];

    public function saveWithRelations()
    {
        return $this->getConnection()->transaction(function () {
            $this->saveOrFail();
            $this->syncRelations();
        });
    }

    private function syncRelations()
    {
        $this->saveRelations();
        $this->deleteDeletedRelations();
    }

    private function deleteDeletedRelations()
    {
        $deletedRelations = $this->deletedRelations;

        foreach ($deletedRelations as $relationName => $relationIds) {
            if (!$relationIds) {
                continue;
            }

            /** @var HasMany $relation */
            $relation = $this->$relationName();
            $relation->getRelated()->destroy($relationIds);
        }
    }


    private function saveRelations()
    {
        // To sync all of the relationships to the database, we will simply spin through
        // the relationships and save each model via this "push" method, which allows
        // us to recurse into all of these nested relations for the model instance.
        foreach ($this->relations as $models) {
            $models = $models instanceof Collection
                ? $models->all() : [$models];

            foreach (array_filter($models) as $model) {
                $model->saveWithRelations();
            }
        }
    }
}