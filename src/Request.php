<?php
declare(strict_types=1);

namespace Falgun\Http;

use Falgun\Http\Parameters\Files;
use Falgun\Http\Parameters\Cookies;
use Falgun\Http\Parameters\Headers;
use Falgun\Http\Parameters\PostDatas;
use Falgun\Http\Parameters\Attributes;
use Falgun\Http\Parameters\QueryDatas;
use Falgun\Http\Parameters\ServerDatas;

class Request implements RequestInterface
{

    public const METHOD_HEAD = 'HEAD';
    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';
    public const METHOD_PUT = 'PUT';
    public const METHOD_PATCH = 'PATCH';
    public const METHOD_DELETE = 'DELETE';

    protected Uri $uri;
    protected QueryDatas $queryDatas;
    protected PostDatas $postDatas;
    protected Attributes $attributes;
    protected Cookies $cookies;
    protected Files $files;
    protected Headers $headers;
    protected ServerDatas $serverDatas;
    protected string $body;

    private final function __construct(
        Uri $uri,
        QueryDatas $queryDatas,
        PostDatas $postDatas,
        Attributes $attributes,
        Headers $headers,
        Cookies $cookies,
        Files $files,
        ServerDatas $serverDatas,
        string $body = ''
    )
    {
        $this->uri = $uri;
        $this->queryDatas = $queryDatas;
        $this->postDatas = $postDatas;
        $this->attributes = $attributes;
        $this->headers = $headers;
        $this->cookies = $cookies;
        $this->files = $files;
        $this->headers = $headers;
        $this->serverDatas = $serverDatas;
        $this->body = $body;
    }

    public static function createFromGlobals(): self
    {
        $uri = Uri::fromServerGlobal($_SERVER);
        $queryDatas = new QueryDatas($_GET);
        $postDatas = new PostDatas($_POST);
        $attributes = new Attributes([]);
        $cookies = new Cookies($_COOKIE);
        $files = new Files($_FILES);
        $headers = new Headers(self::isFpmHeaderMethodAvailable() ? \apache_request_headers() : []);
        $serverDatas = new ServerDatas($_SERVER);
        $body = \file_get_contents('php://input');

        return new static($uri, $queryDatas, $postDatas, $attributes, $headers, $cookies, $files, $serverDatas, $body);
    }

    private static function isFpmHeaderMethodAvailable(): bool
    {
        return (PHP_SAPI !== 'cli' && function_exists('apache_request_headers'));
    }

    public function getMethod(): string
    {
        return $this->serverDatas->get('HTTP_METHOD', 'GET');
    }

    public function isGetMethod(): bool
    {
        return $this->getMethod() == self::METHOD_GET;
    }

    public function isPostMethod(): bool
    {
        return $this->getMethod() == self::METHOD_POST;
    }

    public function isHeadMethod(): bool
    {
        return $this->getMethod() == self::METHOD_HEAD;
    }

    public function setMethod(string $method): self
    {
        $this->serverDatas->set('HTTP_METHOD', \strtoupper($method));

        return $this;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->setBody($body);

        return $this;
    }

    public function uri(): Uri
    {
        return $this->uri;
    }

    public function queryDatas(): QueryDatas
    {
        return $this->queryDatas;
    }

    public function postDatas(): PostDatas
    {
        return $this->postDatas;
    }

    public function attributes(): Attributes
    {
        return $this->attributes;
    }

    public function cookies(): Cookies
    {
        return $this->cookies;
    }

    public function files(): Files
    {
        return $this->files;
    }

    public function headers(): Headers
    {
        return $this->headers;
    }

    public function serverDatas(): ServerDatas
    {
        return $this->serverDatas;
    }
}
