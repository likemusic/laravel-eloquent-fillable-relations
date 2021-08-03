<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Likemusic\LaravelFillableRelationsWithoutAutosave\HasFillableRelationsTrait;
use Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\HasMany;

class Main extends Model
{
    use HasFillableRelationsTrait;

    protected $attributes = [
        'id' => null,
    ];

    protected $fillable = [
        'name',
    ];

    protected $fillableRelations = [
        'details',
    ];

    public function details(): HasMany
    {
        return $this->hasMany(Detail::class);
    }
}
