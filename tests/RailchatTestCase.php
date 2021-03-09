<?php

namespace Railroad\Railchat\Tests;

use Faker\Factory;
use Faker\Generator;
use GetStream\StreamChat\Client;
use Mockery;
use Orchestra\Testbench\TestCase as BaseTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Railroad\Permissions\Services\PermissionService;
use Railroad\Railchat\Factories\StreamClientFactory;
use Railroad\Railchat\Providers\RailchatServiceProvider;

class RailchatTestCase extends BaseTestCase
{
    /**
     * @var Generator
     */
    protected $faker;

    /**
     * @var MockObject
     */
    protected $permissionServiceMock;

    /**
     * @var MockObject
     */
    protected $streamClientFactoryMock;

    /**
     * @var MockObject
     */
    protected $streamClientMock;

    protected function setUp()
    {
        parent::setUp();

        error_reporting(E_ALL);

        $this->faker = Factory::create();

        // create & register mocked permission service
        $this->permissionServiceMock =
            $this->getMockBuilder(PermissionService::class)
                ->disableOriginalConstructor()
                ->getMock();

        $this->app->instance(PermissionService::class, $this->permissionServiceMock);

        // create mocked stream client
        $this->streamClientMock =
            $this->getMockBuilder(Client::class)
                ->disableOriginalConstructor()
                ->getMock();

        // create & register mocked stream client factory
        $this->streamClientFactoryMock = Mockery::mock('alias:Railroad\Railchat\Factories\StreamClientFactory');

        // setup mocked factory to return the mocked stream client
        $this->streamClientFactoryMock
            ->shouldReceive('build')
            ->andReturn($this->streamClientMock);

        $this->app->instance(StreamClientFactory::class, $this->streamClientFactoryMock);
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app->register(RailchatServiceProvider::class);
    }
}
