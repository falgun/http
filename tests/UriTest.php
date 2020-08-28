<?php
declare(strict_types=1);

namespace Falgun\Http\Tests;

use Falgun\Http\Uri;
use PHPUnit\Framework\TestCase;

class UriTest extends TestCase
{

    public function testUriBuilder()
    {
        $server = [
            'SERVER_NAME' => 'localhost',
            'SERVER_PORT' => '8080',
            'SERVER_ADDR' => '127.0.0.1',
            'HTTP_HOST' => 'localhost:8080',
            'REQUEST_URI' => '/falgun-skeleton/public/?test=true',
            'REQUEST_METHOD' => 'GET',
            'QUERY_STRING' => 'test=true',
            'REQUEST_SCHEME' => 'http',
        ];

        $uri = Uri::fromServerGlobal($server);

        $this->assertEquals('localhost', $uri->getHost());

        $this->assertEquals(8080, $uri->getPort());

        $this->assertEquals('/falgun-skeleton/public/', $uri->getPath());

        $this->assertEquals('test=true', $uri->getQuery());

        $this->assertEquals('http', $uri->getScheme());

        $this->assertEquals('http://localhost:8080/falgun-skeleton/public/',
            $uri->getSchemeHostPathWithoutDefaultPort());
    }

    public function testUriFromString()
    {
        $uri = Uri::fromString('https://user:password@www.php.net:443/manual/en/function.parse-url.php?a=foo&b=bar#frag');

        $this->assertEquals('https', $uri->getScheme());
        $this->assertEquals('www.php.net', $uri->getHost());
        $this->assertEquals(443, $uri->getPort());
        $this->assertEquals('/manual/en/function.parse-url.php', $uri->getPath());
        $this->assertEquals('a=foo&b=bar', $uri->getQuery());
        $this->assertEquals('frag', $uri->getFragment());
        $this->assertEquals('user:password', $uri->getUserInfo());


        $this->assertEquals('https://www.php.net/manual/en/function.parse-url.php',
            $uri->getSchemeHostPathWithoutDefaultPort());
        $this->assertEquals('https://www.php.net/manual/en/function.parse-url.php?a=foo&b=bar#frag',
            (string) $uri);
    }
}
