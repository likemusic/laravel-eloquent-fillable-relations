<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave\Tests;

use Likemusic\LaravelFillableRelationsWithoutAutosave\Tests\Models\Main;

class MainDetailsTest extends TestCase
{

    public function testNewMainWithDetails()
    {
        $detailsAttributes1 = [
            [
                'name' => 'detail 1',
            ],
            [
                'name' => 'detail 2',
            ],
        ];

        $main = new Main([
            'name' => 'Main 1',
            'details' => $detailsAttributes1
        ]);

        $main->saveWithRelations();
        $main->fresh();
        $main->load('details');

        $details = $main->details;

        $this->assertCount(2, $details);

        $detail1 = $details[0];
        $this->assertEquals('detail 1', $detail1->name);

        $detail2 = $details[1];
        $this->assertEquals('detail 2', $detail2->name);

        $detail1Attributes = $detail1->toArray();
        $detail1Attributes['name'] = 'Detail 1 - modified';

        $detailsAttributes2 = [
            $detail1Attributes,
            [
                'name' => 'detail 3',
            ],
            [
                'name' => 'detail 4',
            ],
        ];

        $mainAttributes2 = [
            'name' => 'Main 2',
            'details' => $detailsAttributes2
        ];

        $main->fill($mainAttributes2);
        $main->saveWithRelations();


        $main->fresh();
        $main->load('details');

        $details = $main->details;

        $this->assertCount(3, $details);

        $detail1 = $details[0];
        $this->assertEquals('Detail 1 - modified', $detail1->name);
    }
}