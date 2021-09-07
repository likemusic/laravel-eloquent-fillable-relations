<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave\Tests\Models\OneOrMany\One;

use Illuminate\Database\Eloquent\Model;
use Likemusic\LaravelFillableRelationsWithoutAutosave\IsFillableRelationTrait;

class Oner extends Model
{
    use IsFillableRelationTrait;

    protected $fillable = ['name'];
}