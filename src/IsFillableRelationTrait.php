<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave;

use Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\Common\SetAttributeByRefTrait;

trait IsFillableRelationTrait
{
    use SetAttributeByRefTrait, HasFillableRelationsTrait;
}
