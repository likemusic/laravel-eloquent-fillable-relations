<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave\Tests\Models\OneOrMany\Many;

use Illuminate\Database\Eloquent\Model;
use Likemusic\LaravelFillableRelationsWithoutAutosave\IsFillableRelationTrait;

class Manyer extends Model
{
    use IsFillableRelationTrait;

    protected $fillable = ['name'];
}
