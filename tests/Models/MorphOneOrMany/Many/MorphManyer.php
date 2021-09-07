<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave\Tests\Models\MorphOneOrMany\Many;

use Illuminate\Database\Eloquent\Model;
use Likemusic\LaravelFillableRelationsWithoutAutosave\IsFillableRelationTrait;

class MorphManyer extends Model
{
    use IsFillableRelationTrait;

    protected $fillable = ['name'];

    public function manyerable()
    {
        return $this->morphTo();
    }
}