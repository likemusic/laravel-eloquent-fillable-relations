<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\Common;

trait GetParentKeyByRefTrait
{
    public function & getParentKeyByRef()
    {
        return $this->parent->getAttributeValueByRef($this->localKey);
    }
}