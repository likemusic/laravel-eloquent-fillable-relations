<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave\Relations;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany as BaseHasMany;
use Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\Common\GetParentKeyByRefTrait;
use Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\Common\SetAttributeByRefTrait;
use function tap;


class HasMany extends BaseHasMany
{
    use GetParentKeyByRefTrait;

    /**
     * @param Model|SetAttributeByRefTrait $model
     */
    protected function setForeignAttributesForCreate(Model $model)
    {
        $value = &$this->getParentKeyByRef();
        $model->setAttributeByRef($this->getForeignKeyName(), $value);
    }

    public function newByAttributes(array $attributes)
    {
        return $this->newRelatedInstances($attributes);
    }

    public function updateByAttributes(array $collectionAttributes, Collection $oldRelationValue)
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

    /**
     * Create a new instance of the related model.
     *
     * @param array $attributes
     * @return Model
     */
    public function newRelatedInstance(array $attributes = [])
    {
        return tap($this->related->newInstance($attributes), function ($instance) {
            $this->setForeignAttributesForCreate($instance);
        });
    }

    /**
     * Create a Collection of new instances of the related model.
     *
     * @param iterable $records
     * @return Collection
     */
    public function newRelatedInstances(iterable $records)
    {
        $instances = $this->related->newCollection();

        foreach ($records as $record) {
            $instances->push($this->newRelatedInstance($record));
        }

        return $instances;
    }

}