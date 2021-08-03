<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Likemusic\LaravelFillableRelationsWithoutAutosave\IsFillableRelationTrait;

class Detail extends Model
{
    use IsFillableRelationTrait;

    protected $fillable = ['name'];
}
