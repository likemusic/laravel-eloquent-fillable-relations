<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\Common;

trait PushTrait
{
    public function push()
    {
        if (! $this->save()) {
            return false;
        }

        return $this->syncRelations();
    }
}
