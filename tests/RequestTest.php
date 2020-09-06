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
            'REQUEST_METHOD' => 'post',
            'QUERY_STRING' => 'test=true',
            'REQUEST_SCHEME' => 'http',
            'SCRIPT_FILENAME' => '/home/user/falgun-skeleton/public/index.php',
            'SCRIPT_NAME' => '/falgun-skeleton/public/index.php',
            'PHP_SELF' => '/falgun-skeleton/public/index.php',
        ];
        $_GET = ['test' => 'true'];
        $_POST = ['post' => 'true'];
        $_COOKIE = [];
        $_FILES = [];


        $request = Request::createFromGlobals();

        $this->assertEquals($request->getMethod(), 'POST');
        $this->assertEquals($request->uri()->getHost(), 'localhost');
        $this->assertEquals($request->queryDatas()->get('test'), 'true');
        $this->assertEquals($request->postDatas()->get('post'), 'true');
        $this->assertEquals($request->attributes()->all(), []);
        $this->assertEquals($request->files()->all(), []);
    }
}
