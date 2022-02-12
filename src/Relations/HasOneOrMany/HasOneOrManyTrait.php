<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\HasOneOrMany;

use Illuminate\Database\Eloquent\Model;
use Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\Common\SetAttributeByRefTrait;
use Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\Common\UpdateForeignKeyByRefTrait;

trait HasOneOrManyTrait
{
    use UpdateForeignKeyByRefTrait;

    /**
     * @param Model|SetAttributeByRefTrait $model
     */
    protected function setForeignAttributesForCreate(Model $model)
    {
        parent::setForeignAttributesForCreate($model);
        $this->updateForeignKeyByRef($model);
    }
}
