<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave\Tests\Models\MorphOneOrMany\Many;

use Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\MorphOneOrMany\MorphMany;

trait WithMorphManyersTrait
{
    public function manyers(): MorphMany
    {
        return $this->morphMany(
            MorphManyer::class,
            'manyerable'
        );
    }
}