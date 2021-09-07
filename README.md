# Laravel Eloquent fillable relations

Allows automatically fill model's relations by attributes without create them in database. Also adds `pushOrFail()`
model's method that save model with relations (like `push()`-method) in one transaction.

Currently, implemented relations:

- HasOne;
- HasMany;
- MorphMany;

## Usage example

## For owner model

- Use trait `Likemusic\LaravelFillableRelationsWithoutAutosave\HasFillableRelationsTrait`.
- Change HasMany-relation namespace
  to `Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\HasOneOrMany\HasMany`;
- Add fillable relations to `$fillableRelations` property;
- Set for `$attributes` property default `id` value to `null`;

```php
use Illuminate\Database\Eloquent\Model;
use Likemusic\LaravelFillableRelationsWithoutAutosave\HasFillableRelationsTrait;
use Likemusic\LaravelFillableRelationsWithoutAutosave\Relations\HasOneOrMany\HasMany;

class Main extends Model
{
    // REQUIRED FOR AGGREGATE ROOT MODEL
    use HasFillableRelationsTrait;

    protected $fillableRelations = [
        'details',
    ];
    // END REQUIRED

    protected $attributes = [
        'id' => null,
    ];

    protected $fillable = [
        'name',
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
    // REQUIRED FOR AGGREGATE RELATION MODEL
    use IsFillableRelationTrait;
    // END REQUIRED

    protected $fillable = ['name'];
}
```

# In caller

Create or get owner model and fill with provided values and call `pushOrFail()`-method.

```php

    // Create aggregate root with relations by attributes.
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

    // Save aggregate root with relations
    $main->pushOrFail();
    
    
    $details = $main->details;
    $firstDetail = reset($details);
    $firstDetailAttributes = $firstDetail->toArray();
    
    // Update relation attribute
    $firstDetailAttributes['name'] = 'Modified detail 1';

    // Update aggregate with relations by attributes
    $main->fill([
        'name' => 'Main 1',
        'details' => [
            $firstDetailAttributes,
            [
                'name' => 'detail 3',
            ],
        ],        
    ]);

    // Save changes
    $main->pusOrFail();
    // Here:
    // - `detail 1` would be updated,
    // - `detail 2` would be deleted,
    // - `detail 3` would be added.
```

## Hooks methods when save with relations

Below shown call stack for `pushOrFail()` method. Method names selected by bold font is protected function that you may
overload to do some work. For example, if your model can have many attachments, that stored in filesystem, where path of
file contains id of main entity, then you could handle you uploaded files in some of this "hook" methods, to replace
uploaded file to filenames etc.

- pushOrFail()
    - saveOrFail()
    - syncRelations()
        - **beforeSyncRelations()**
        - saveRelations()
            - **beforeSaveRelations()**
            - saveRelation() - for each relation
                - **beforeSaveRelation($relationName, $relationValue)**
                - pushOrFail() - for each model in relation
                - **afterSaveRelation($relationName, $relationValue)**
            - **afterSaveRelations()**
        - deleteDeletedRelations()
        - **afterSyncRelations()**

## TODO

- overload push() to call `hook`-methods;
- implement for remains relation types;
- test move items between main entities for "many" relations;
