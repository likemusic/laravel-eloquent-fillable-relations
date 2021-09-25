<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\Common;

use Illuminate\Database\Eloquent\Model;

trait PushOrFailTrait
{
    use SyncRelationsOrFailTrait;

    private $deletedRelations = [];

    public function pushOrFail(): Model
    {
        return $this->getConnection()->transaction(function () {
            $this->saveOrFail();
            $this->syncRelationsOrFail();

            return $this;
        });
    }
}
