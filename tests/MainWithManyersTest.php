<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave\Tests;

use Likemusic\LaravelFillableRelationsWithoutAutosave\Tests\Models\OneOrMany\Many\MainWithManyers;

class MainWithManyersTest extends TestCase
{
    public function testCreate()
    {
        $manyersAttributes1 = [
            [
                'name' => 'manyer 1',
            ],
            [
                'name' => 'manyer 2',
            ],
        ];

        $main = new MainWithManyers([
            'name' => 'Main 1',
            'manyers' => $manyersAttributes1
        ]);

        $main->pushOrFail();
        $main->fresh();
        $main->load('manyers');

        $manyers = $main->manyers;

        $this->assertCount(2, $manyers);

        $manyer1 = $manyers[0];
        $this->assertEquals('manyer 1', $manyer1->name);

        $manyer2 = $manyers[1];
        $this->assertEquals('manyer 2', $manyer2->name);

        return $main;
    }

    public function testUpdateRelationByUpdateItem()
    {
        $main = $this->testCreate();

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
        $main = $this->testCreate();

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
        $main = $this->testCreate();

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