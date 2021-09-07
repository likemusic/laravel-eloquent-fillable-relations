<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave\Tests\Models\Base;

use Illuminate\Database\Eloquent\Model;
use Likemusic\LaravelFillableRelationsWithoutAutosave\HasFillableRelationsTrait;

class BaseMain extends Model
{
    use HasFillableRelationsTrait;

    protected $table = 'mains';

    protected $attributes = [
        'id' => null,
    ];

    protected $fillable = [
        'name',
    ];

}