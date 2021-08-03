<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\Common;

trait SetAttributeByRefTrait
{
    public function setAttributeByRef($key, &$value)
    {
        $this->attributes[$key] = &$value;
    }
}