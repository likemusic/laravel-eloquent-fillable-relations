<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave\Tests\Models\MorphOneOrMany\Many;

use Likemusic\LaravelFillableRelationsWithoutAutosave\Tests\Models\Base\BaseMain;

class BaseMainWithMorphMany extends BaseMain
{
    use WithMorphManyersTrait;

    protected $fillableRelations = [
        'manyers',
    ];
}