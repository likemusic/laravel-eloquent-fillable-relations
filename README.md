# laravel-fillable-has-many

Allows fill hasMany() relations by attributes without create them in database.
Also adds `saveWithRelations()` model's method.

## Usage example

## For owner model

- Use trait `Likemusic\LaravelFillableRelationsWithoutAutosave\HasFillableRelationsTrait`.
- Change HasMany-relation namespace to `Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\HasMany`;
- Add fillable relations to `$fillableRelations` property;
- Set for `$attributes` property default `id` value to `null`;

```php
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
```

# For aggregated model

- Use trait `Likemusic\LaravelFillableRelationsWithoutAutosave\IsFillableRelationTrait`;

```php
use Illuminate\Database\Eloquent\Model;
use Likemusic\LaravelFillableRelationsWithoutAutosave\IsFillableRelationTrait;

class Detail extends Model
{
    use IsFillableRelationTrait;

    protected $fillable = ['name'];
}
```

# In caller

Create or get owner model and fill with provided values and call `saveWithRelations()`-method.

```php
    $main = new Main([
        'name' => 'Main 1',
        'details' => [
            [
                'name' => 'detail 1',
            ],
            [
                'name' => 'detail 2',
            ],
        ],
    ]);

    $main->saveWithRelations();
    
    
    $details = $main->details;
    $firstDetail = reset($details);
    $firstDetailAttributes = $firstDetail->toArray();
    $firstDetailAttributes['name'] = 'Modified detail 1';

    $main->fill([
        'name' => 'Main 1',
        'details' => [
            $firstDetailAttributes,
            [
                'name' => 'detail 3',
            ],
        ],        
    ]);

    $main->saveWithRelations();
    // Here `detail 1` would be updated, `detail 2` would be deleted, `detail 3` would be added.
```
