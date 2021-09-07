<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave\Tests\Models\OneOrMany\One;

use Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\HasOneOrMany\HasOne;

trait WithOnerTrait
{
    public function oner(): HasOne
    {
        return $this->hasOne(Oner::class, 'main_id');
    }
}