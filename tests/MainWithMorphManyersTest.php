<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave\Tests;

use Likemusic\LaravelFillableRelationsWithoutAutosave\Tests\Models\MorphOneOrMany\Many\MainWithMorphManyFirst;
use Likemusic\LaravelFillableRelationsWithoutAutosave\Tests\Models\MorphOneOrMany\Many\MainWithMorphManySecond;

class MainWithMorphManyersTest extends TestCase
{
    public function testCreateFirstByNew()
    {
        $manyersAttributes1 = [
            [
                'name' => 'Morph manyer 1 - for first main',
            ],
            [
                'name' => 'Morph manyer 2 - for first main',
            ],
        ];

        $main = new MainWithMorphManyFirst([
            'name' => 'Main with morph fist',
            'manyers' => $manyersAttributes1
        ]);

        $main->pushOrFail();
        $main->fresh();
        $main->load('manyers');

        $manyers = $main->manyers;

        $this->assertCount(2, $manyers);

        $manyer1 = $manyers[0];
        $this->assertEquals('Morph manyer 1 - for first main', $manyer1->name);

        $manyer2 = $manyers[1];
        $this->assertEquals('Morph manyer 2 - for first main', $manyer2->name);

        return $main;
    }

    public function testCreateFirstByCreateWithRelations()
    {
        $manyersAttributes1 = [
            [
                'name' => 'Morph manyer 1 - for first main',
            ],
            [
                'name' => 'Morph manyer 2 - for first main',
            ],
        ];

        $main = MainWithMorphManyFirst::createWithRelations([
            'name' => 'Main with morph fist',
            'manyers' => $manyersAttributes1
        ]);

        $main->fresh();
        $main->load('manyers');

        $manyers = $main->manyers;

        $this->assertCount(2, $manyers);

        $manyer1 = $manyers[0];
        $this->assertEquals('Morph manyer 1 - for first main', $manyer1->name);

        $manyer2 = $manyers[1];
        $this->assertEquals('Morph manyer 2 - for first main', $manyer2->name);

        return $main;
    }

    public function testCreateSecond()
    {
        $manyersAttributes1 = [
            [
                'name' => 'Morph manyer 1 - for second main',
            ],
            [
                'name' => 'Morph manyer 2 - for second main',
            ],
        ];

        $main = new MainWithMorphManySecond([
            'name' => 'Main with morph second',
            'manyers' => $manyersAttributes1
        ]);

        $main->pushOrFail();
        $main->fresh();
        $main->load('manyers');

        $manyers = $main->manyers;

        $this->assertCount(2, $manyers);

        $manyer1 = $manyers[0];
        $this->assertEquals('Morph manyer 1 - for second main', $manyer1->name);

        $manyer2 = $manyers[1];
        $this->assertEquals('Morph manyer 2 - for second main', $manyer2->name);

        return $main;
    }

    public function testCreateFirstAndSecond()
    {
        $this->testCreateFirstByNew();
        $this->testCreateSecond();
    }

    public function testUpdateRelationByUpdateItem()
    {
        $main = $this->testCreateFirstByNew();

        $manyers = $main->manyers;
        $manyersAttributes = $manyers->toArray();

        $manyer1Attributes = $manyersAttributes[0];
        $manyer1Attributes['name'] = 'Detail 1 - modified';

        $manyersAttributes[0] = $manyer1Attributes;

        $mainAttributes = [
            'manyers' => $manyersAttributes,
        ];

        $main->fill($mainAttributes);
        $main->pushOrFail();

        $main->fresh();
        $main->load('manyers');

        $manyers = $main->manyers;

        $this->assertCount(2, $manyers);

        $manyer1 = $manyers[0];
        $this->assertEquals('Detail 1 - modified', $manyer1->name);
    }

    public function testUpdateRelationByUpdateAndAddAndDeleteItems()
    {
        $main = $this->testCreateFirstByNew();

        $manyers = $main->manyers;
        $manyer = $manyers[0];

        $manyer1Attributes = $manyer->toArray();
        $manyer1Attributes['name'] = 'Detail 1 - modified';

        $manyersAttributes2 = [
            $manyer1Attributes,
            [
                'name' => 'detail 3',
            ],
            [
                'name' => 'detail 4',
            ],
        ];

        $mainAttributes = [
            'name' => 'Main 2',
            'manyers' => $manyersAttributes2
        ];

        $main->fill($mainAttributes);
        $main->pushOrFail();


        $main->fresh();
        $main->load('manyers');

        $manyers = $main->manyers;

        $this->assertCount(3, $manyers);

        $manyer = $manyers[0];
        $this->assertEquals('Detail 1 - modified', $manyer->name);
    }

    public function testUpdateAndAddAndDelete()
    {
        $main = $this->testCreateFirstByNew();

        $manyers = $main->manyers;
        $manyer = $manyers[0];

        $manyer1Attributes = $manyer->toArray();
        $manyer1Attributes['name'] = 'Detail 1 - modified';

        $manyersAttributes2 = [
            $manyer1Attributes,
            [
                'name' => 'detail 3',
            ],
            [
                'name' => 'detail 4',
            ],
        ];

        $mainAttributes = [
            'name' => 'Main 2',
            'manyers' => $manyersAttributes2
        ];

        $main->fill($mainAttributes);
        $main->pushOrFail();


        $main->fresh();
        $main->load('manyers');

        $manyers = $main->manyers;

        $this->assertCount(3, $manyers);

        $manyer = $manyers[0];
        $this->assertEquals('Detail 1 - modified', $manyer->name);
    }
}