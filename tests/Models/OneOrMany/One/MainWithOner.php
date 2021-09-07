<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave\Tests\Models\OneOrMany\One;

use Likemusic\LaravelFillableRelationsWithoutAutosave\Tests\Models\Base\BaseMain;

class MainWithOner extends BaseMain
{
    use WithOnerTrait;

    protected $fillableRelations = [
        'oner',
    ];
}