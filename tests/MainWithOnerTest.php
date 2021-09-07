<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave\Tests;

use Likemusic\LaravelFillableRelationsWithoutAutosave\Tests\Models\OneOrMany\One\MainWithOner;

class MainWithOnerTest extends TestCase
{
    public function testCreate()
    {
        $onerAttributes = [
            'name' => 'Oner 1',
        ];

        $main = new MainWithOner([
            'name' => 'Main With Oner',
            'oner' => $onerAttributes
        ]);

        $main->pushOrFail();
        $main->fresh();
        $main->load('oner');

        $oner = $main->oner;
        $this->assertEquals('Oner 1', $oner->name);

        return $main;
    }

    public function testUpdateRelationByUpdate()
    {
        $main = $this->testCreate();

        $oner = $main->oner;
        $onerAttributes = $oner->toArray();

        $onerAttributes['name'] = 'Oner 1 - modified';
        $mainAttributes = [
            'oner' => $onerAttributes,
        ];

        $main->fill($mainAttributes);
        $main->pushOrFail();

        $main->fresh();
        $main->load('oner');

        $oner = $main->oner;
        $this->assertEquals('Oner 1 - modified', $oner->name);
    }

    public function testUpdateRelationByDelete()
    {
        $main = $this->testCreate();

        $mainAttributes = [
            'oner' => null,
        ];

        $main->fill($mainAttributes);
        $main->pushOrFail();

        $main->fresh();
        $main->load('oner');

        $oner = $main->oner;
        $this->assertNull($oner);
    }
}