<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\Common;

use Illuminate\Database\Eloquent\Model;

trait UpdateForeignKeyByRefTrait
{
    /**
     * @return mixed
     */
    public function & getParentKeyByRef()
    {
        return $this->parent->getAttributeValueByRef($this->localKey);
    }

    protected function updateForeignKeyByRef(Model $model)
    {
        $value = &$this->getParentKeyByRef();
        $this->setForeignKeyByRef($model, $value);
    }

    protected function setForeignKeyByRef(Model $model, &$value)
    {
        $foreignKeyName = $this->getForeignKeyName();

        $model->setAttributeByRef($foreignKeyName, $value);
    }
}
