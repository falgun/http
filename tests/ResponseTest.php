<?php
declare(strict_types=1);

namespace Falgun\Http\Tests;

use Falgun\Http\Response;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{

    public function testResponseCreation()
    {
        $response = new Response('hello world', 200, 'OK');

        $this->assertEquals('hello world', $response->getBody());
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('OK', $response->getReasonPhrase());
    }

    public function testJsonResponse()
    {
        $response = Response::json(['text' => 'hello world']);

        $this->assertEquals('{"text":"hello world"}', $response->getBody());
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('OK', $response->getReasonPhrase());
        $this->assertEquals('application/json', $response->headers()->get('Content-Type'));
    }

    public function testInvalidLowStatusCode()
    {
        $this->expectException(\InvalidArgumentException::class);

        $response = new Response('hello world', 99, 'OK');
    }

    public function testInvalidHighStatusCode()
    {
        $this->expectException(\InvalidArgumentException::class);

        $response = new Response('hello world', 600, 'OK');
    }
}
