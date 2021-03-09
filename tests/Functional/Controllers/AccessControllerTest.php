<?php

namespace Railroad\Railchat\Tests\Functional\Controllers;

use Exception;
use GetStream\StreamChat\StreamException;
use Railroad\Railchat\Tests\RailchatTestCase;

class AccessControllerTest extends RailchatTestCase
{
    public function test_ban_user_validation()
    {
        $this->permissionServiceMock->method('can')->willReturn(true);

        $response = $this->call('POST', '/ban-user', []);

        // assert the response status code
        $this->assertEquals(422, $response->getStatusCode());

        // assert that all the validation errors are returned
        $this->assertEquals(
            [
                [
                    'title' => 'Validation failed.',
                    'source' => 'user_id',
                    'detail' => 'The user id field is required.',
                ]
            ],
            $response->decodeResponseJson('errors')
        );
    }

    public function test_ban_user_stream_not_found_error()
    {
        $this->permissionServiceMock->method('can')->willReturn(true);

        // setup getsream not found exception
        $this->streamClientMock
            ->method('banUser')
            ->willThrowException(
                new StreamException('', 404)
            );

        $response = $this->call(
            'POST',
            '/ban-user',
            [
                'user_id' => $this->faker->numberBetween(1, 100)
            ]
        );

        // assert the response status code
        $this->assertEquals(404, $response->getStatusCode());

        // assert the error message
        $this->assertEquals(
            [
                [
                    'title' => 'Not found.',
                    'detail' => 'StreamChat could not find specified user',
                ]
            ],
            $response->decodeResponseJson('errors')
        );
    }

    public function test_ban_user_stream_error()
    {
        $this->permissionServiceMock->method('can')->willReturn(true);

        // setup getsream generic exception
        $this->streamClientMock
            ->method('banUser')
            ->willThrowException(
                new StreamException('', $this->faker->numberBetween(405, 499))
            );

        $response = $this->call(
            'POST',
            '/ban-user',
            [
                'user_id' => $this->faker->numberBetween(1, 100)
            ]
        );

        // assert the response status code
        $this->assertEquals(503, $response->getStatusCode());

        // assert the error message
        $this->assertEquals(
            [
                [
                    'title' => 'StreamChat Exception',
                    'detail' => 'StreamChat exception occured while trying to ban user',
                ]
            ],
            $response->decodeResponseJson('errors')
        );
    }

    public function test_ban_user_error()
    {
        $this->permissionServiceMock->method('can')->willReturn(true);

        // setup generic exception
        $this->streamClientMock
            ->method('banUser')
            ->willThrowException(
                new Exception('')
            );

        $response = $this->call(
            'POST',
            '/ban-user',
            [
                'user_id' => $this->faker->numberBetween(1, 100)
            ]
        );

        // assert the response status code
        $this->assertEquals(500, $response->getStatusCode());

        // assert the error message
        $this->assertEquals(
            [
                [
                    'title' => 'Railchat Exception',
                    'detail' => 'Exception occured while trying to ban user',
                ]
            ],
            $response->decodeResponseJson('errors')
        );
    }

    public function test_ban_user()
    {
        $this->permissionServiceMock->method('can')->willReturn(true);

        $response = $this->call(
            'POST',
            '/ban-user',
            [
                'user_id' => $this->faker->numberBetween(1, 100)
            ]
        );

        // assert the response status code
        $this->assertEquals(200, $response->getStatusCode());

        // assert empty response
        $this->assertEquals([], $response->decodeResponseJson());
    }

    public function test_unban_user_validation()
    {
        $this->permissionServiceMock->method('can')->willReturn(true);

        $response = $this->call('POST', '/unban-user', []);

        // assert the response status code
        $this->assertEquals(422, $response->getStatusCode());

        // assert that all the validation errors are returned
        $this->assertEquals(
            [
                [
                    'title' => 'Validation failed.',
                    'source' => 'user_id',
                    'detail' => 'The user id field is required.',
                ]
            ],
            $response->decodeResponseJson('errors')
        );
    }

    public function test_unban_user_stream_not_found_error()
    {
        $this->permissionServiceMock->method('can')->willReturn(true);

        // setup getsream not found exception
        $this->streamClientMock
            ->method('unbanUser')
            ->willThrowException(
                new StreamException('', 404)
            );

        $response = $this->call(
            'POST',
            '/unban-user',
            [
                'user_id' => $this->faker->numberBetween(1, 100)
            ]
        );

        // assert the response status code
        $this->assertEquals(404, $response->getStatusCode());

        // assert the error message
        $this->assertEquals(
            [
                [
                    'title' => 'Not found.',
                    'detail' => 'StreamChat could not find specified user',
                ]
            ],
            $response->decodeResponseJson('errors')
        );
    }

    public function test_unban_user_stream_error()
    {
        $this->permissionServiceMock->method('can')->willReturn(true);

        // setup getsream generic exception
        $this->streamClientMock
            ->method('unbanUser')
            ->willThrowException(
                new StreamException('', $this->faker->numberBetween(405, 499))
            );

        $response = $this->call(
            'POST',
            '/unban-user',
            [
                'user_id' => $this->faker->numberBetween(1, 100)
            ]
        );

        // assert the response status code
        $this->assertEquals(503, $response->getStatusCode());

        // assert the error message
        $this->assertEquals(
            [
                [
                    'title' => 'StreamChat Exception',
                    'detail' => 'StreamChat exception occured while trying to unban user',
                ]
            ],
            $response->decodeResponseJson('errors')
        );
    }

    public function test_unban_user_error()
    {
        $this->permissionServiceMock->method('can')->willReturn(true);

        // setup generic exception
        $this->streamClientMock
            ->method('unbanUser')
            ->willThrowException(
                new Exception('')
            );

        $response = $this->call(
            'POST',
            '/unban-user',
            [
                'user_id' => $this->faker->numberBetween(1, 100)
            ]
        );

        // assert the response status code
        $this->assertEquals(500, $response->getStatusCode());

        // assert the error message
        $this->assertEquals(
            [
                [
                    'title' => 'Railchat Exception',
                    'detail' => 'Exception occured while trying to unban user',
                ]
            ],
            $response->decodeResponseJson('errors')
        );
    }

    public function test_unban_user()
    {
        $this->permissionServiceMock->method('can')->willReturn(true);

        $response = $this->call(
            'POST',
            '/unban-user',
            [
                'user_id' => $this->faker->numberBetween(1, 100)
            ]
        );

        // assert the response status code
        $this->assertEquals(200, $response->getStatusCode());

        // assert empty response
        $this->assertEquals([], $response->decodeResponseJson());
    }
}
