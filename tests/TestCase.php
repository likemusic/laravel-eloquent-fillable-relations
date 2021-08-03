<?php

namespace Likemusic\LaravelFillableRelationsWithoutAutosave\Tests;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\Application;
use Mockery;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh', ['--database' => 'test']);
        $this->beforeApplicationDestroyed(function () {
            $this->artisan('migrate:rollback');
        });
    }

    /**
     * Define environment setup.
     *
     * @param Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // set up database configuration
        $app['config']->set('database.default', 'test');
        $app['config']->set('database.connections.test', [
            'driver' => 'mysql',
            'database' => 'test',
            'host' => 'mysql',
            'username' => 'test',
            'password' => 'test',
            'prefix' => '',
        ]);
        /*
        $app['config']->set('database.connections.testbench', [
            'driver' => 'mysql',
            'database' => 'fillable_relations_test',
            'host' => 'localhost',
            'username' => 'root',
        ]);
        */
    }

    /**
     * Get Sluggable package providers.
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            TestServiceProvider::class
        ];
    }

    /**
     * Mock the event dispatcher so all events are silenced and collected.
     *
     * @return $this
     */
    protected function withoutEvents()
    {
        $mock = Mockery::mock(Dispatcher::class);
        $mock->shouldReceive('fire', 'until');
        $this->app->instance('events', $mock);
        return $this;
    }
}
