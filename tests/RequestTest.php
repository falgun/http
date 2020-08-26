<?php
declare(strict_types=1);

namespace Falgun\Http\Tests;

use Falgun\Http\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{

    public function testRequestCreation()
    {
        $_SERVER = [
            'SERVER_NAME' => 'localhost',
            'SERVER_PORT' => '8080',
            'SERVER_ADDR' => '127.0.0.1',
            'HTTP_HOST' => 'localhost:8080',
            'REQUEST_URI' => '/falgun-skeleton/public/?test=true',
            'REQUEST_METHOD' => 'POST',
            'QUERY_STRING' => 'test=true',
            'REQUEST_SCHEME' => 'http',
        ];
        $_GET = ['test' => 'true'];
        $_POST = ['post' => 'true'];
        $_COOKIE = [];
        $_FILES = [];


        $request = Request::createFromGlobals();

        $this->assertEquals($request->uri()->getHost(), 'localhost');
        $this->assertEquals($request->queryDatas()->get('test'), 'true');
        $this->assertEquals($request->postDatas()->get('post'), 'true');
        $this->assertEquals($request->attributes()->all(), []);
        $this->assertEquals($request->files()->all(), []);

        $_FILES = [
            'file1' => [
                'name' => [
                    0 => 'MyFile1.jpg',
                    1 => 'MyFile2.jpg'
                ],
                'type' => [
                    0 => 'image/jpeg',
                    1 => 'image/png'
                ],
                'tmp_name' => [
                    0 => '/tmp/php/php6hst32',
                    1 => '/tmp/php/php6hst33'
                ],
                'error' => [
                    0 => UPLOAD_ERR_OK,
                    1 => UPLOAD_ERR_OK
                ],
                'size' => [
                    0 => 98174,
                    1 => 15555
                ],
            ],
        ];


        $request = Request::createFromGlobals();

        $expected = [
            0 => [
                'name' => 'MyFile1.jpg',
                'type' => 'image/jpeg',
                'tmp_name' => '/tmp/php/php6hst32',
                'error' => UPLOAD_ERR_OK,
                'size' => 98174
            ],
            1 => [
                'name' => 'MyFile2.jpg',
                'type' => 'image/png',
                'tmp_name' => '/tmp/php/php6hst33',
                'error' => UPLOAD_ERR_OK,
                'size' => 15555
            ],
        ];

        $this->assertEquals($expected, $request->files()->get('file1'));
    }
}
