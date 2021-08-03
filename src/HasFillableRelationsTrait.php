<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\Common\SaveWithRelationsOrFailTrait;
use Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\HasMany;

trait HasFillableRelationsTrait
{
    use SaveWithRelationsOrFailTrait;

    public function & getAttributeValueByRef($key)
    {
        $attributes = &$this->attributes;

        return $attributes[$key];
    }

    public function fill(array $attributes)
    {
        $ret = parent::fill($attributes);

        $this->fillRelations($attributes);

        return $ret;
    }

    private function fillRelations($attributes)
    {
        array_walk($this->fillableRelations, function ($relationName) use ($attributes) {
            $this->fillRelation($relationName, $attributes);
        });
    }

    private function fillRelation($relationName, $attributes)
    {
        if (!array_key_exists($relationName, $attributes)) {
            return;
        }

        $relationAttributes = $attributes[$relationName];

        $this->fillRelationByAttributes($relationName, $relationAttributes);
    }

    private function fillRelationByAttributes($relationName, $relationAttributes)
    {
        $oldRelationValue = $this->getRelationValue($relationName);

        [$updatedRelationValue, $deletedRelationIds] = $this->updateRelationValue($relationName, $relationAttributes, $oldRelationValue);

        $this->setRelation($relationName, $updatedRelationValue);
        $this->setDeletedRelations($relationName, $deletedRelationIds);
    }

    private function setDeletedRelations($relationName, $deletedIds)
    {
        $this->deletedRelations[$relationName] = $deletedIds;
    }

    private function updateRelationValue($relationName, $relationAttributes, $oldRelationValue)
    {
        $relation = $this->$relationName();

        return $relation->updateByAttributes($relationAttributes, $oldRelationValue);
    }

    private function newRelationValue($relationName, $relationAttributes)
    {
        $relation = $this->$relationName();

        $relation->newByAttributes($relationAttributes);
    }

    protected function newHasMany(Builder $query, Model $parent, $foreignKey, $localKey)
    {
        return new HasMany($query, $parent, $foreignKey, $localKey);
    }
}