<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave\Tests\Models\OneOrMany\Many;

use Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\HasOneOrMany\HasMany;
use Likemusic\LaravelFillableRelationsWithoutAutosave\Tests\Models\OneOrMany\Many\Manyer;

trait WithManyersTrait
{
    public function manyers(): HasMany
    {
        return $this->hasMany(
            Manyer::class,
            'main_id',
        );
    }
}