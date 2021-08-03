<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave;

use Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\Common\SaveWithRelationsOrFailTrait;
use Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\Common\SetAttributeByRefTrait;

trait IsFillableRelationTrait
{
    use SetAttributeByRefTrait, SaveWithRelationsOrFailTrait;
}