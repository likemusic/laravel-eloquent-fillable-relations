<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\Common\PushOrFailTrait;
use Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\HasOneOrMany\HasMany;
use Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\HasOneOrMany\HasOne;
use Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\MorphOneOrMany\MorphMany;

//use Illuminate\Database\Eloquent\Relations\HasOne;
//use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasFillableRelationsTrait
{
    use PushOrFailTrait;

    public function & getAttributeValueByRef($key)
    {
        $attributes = &$this->attributes;

        return $attributes[$key];
    }

    public function fill(array $attributes)
    {
        $ret = parent::fill($attributes);

        $this->fillRelationsIfRequired($attributes);

        return $ret;
    }

    private function fillRelationsIfRequired($attributes)
    {
        if (!$this->isFillRealationsRequired()) {
            return;
        }

        $this->fillRelations($attributes);
    }

    private function isFillRealationsRequired()
    {
        return !empty($this->fillableRelations);
    }

    private function fillRelations($attributes)
    {
        array_walk($this->fillableRelations, function ($relationName) use ($attributes) {
            $this->fillRelation($relationName, $attributes);
        });
    }

    private function fillRelation($relationName, $attributes)
    {
        $origRelationName = $relationName;
        $snakeRelationName = Str::snake($relationName);

        if (array_key_exists($origRelationName, $attributes)) {
            $resultRelationName = $origRelationName;
        } elseif (array_key_exists($snakeRelationName, $attributes)) {
            $resultRelationName = $snakeRelationName;
        } else {
            return;
        }

        $relationAttributes = $attributes[$resultRelationName];

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

//    private function newRelationValue($relationName, $relationAttributes)
//    {
//        $relation = $this->$relationName();
//
//        $relation->makeMany($relationAttributes);
//    }

    protected function newHasMany(Builder $query, Model $parent, $foreignKey, $localKey)
    {
        return new HasMany($query, $parent, $foreignKey, $localKey);
    }

    protected function newHasOne(Builder $query, Model $parent, $foreignKey, $localKey)
    {
        return new HasOne($query, $parent, $foreignKey, $localKey);
    }

    protected function newMorphMany(Builder $query, Model $parent, $type, $id, $localKey)
    {
        return new MorphMany($query, $parent, $type, $id, $localKey);
    }
}
