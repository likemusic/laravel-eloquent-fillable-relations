<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave\Tests\Models\OneOrMany\Many;

use Likemusic\LaravelFillableRelationsWithoutAutosave\Tests\Models\Base\BaseMain;
use Likemusic\LaravelFillableRelationsWithoutAutosave\Tests\Models\OneOrMany\Many\WithManyersTrait;

class MainWithManyers extends BaseMain
{
    use WithManyersTrait;

    protected $fillableRelations = [
        'manyers',
    ];
}
