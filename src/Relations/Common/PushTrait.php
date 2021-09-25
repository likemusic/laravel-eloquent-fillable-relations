<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\Common;

trait PushTrait
{
    use SyncRelationsTrait;

    public function push()
    {
        if (! $this->save()) {
            return false;
        }

        return $this->syncRelations();
    }
}
