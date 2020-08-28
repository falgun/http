<?php
declare(strict_types=1);

namespace Falgun\Http;

use Falgun\Http\Parameters\Cookies;
use Falgun\Http\Parameters\Headers;

class Response implements ResponseInterface
{

    protected Headers $headers;
    protected Cookies $cookies;
    protected string $body;
    protected int $statusCode;
    protected string $reasonPhrase;

    public function __construct(string $body = '', int $statusCode = 200, string $reasonPhrase = 'OK')
    {
        $this->headers = new Headers();
        $this->cookies = new Cookies();
        $this->body = $body;
        $this->setStatusCode($statusCode, $reasonPhrase);
    }

    public static function json($value, int $statusCode = 200, string $reasonPhrase = 'OK'): self
    {
        $json = json_encode($value, \JSON_THROW_ON_ERROR);

        $response = new static($json, $statusCode, $reasonPhrase);

        $response->headers()->set('Content-Type', 'application/json');

        return $response;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function setStatusCode(int $code, string $reason = ''): self
    {
        if ($code < 100 || $code > 599) {
            throw new \InvalidArgumentException('http code must be between 100 to 599');
        }

        $this->statusCode = $code;
        $this->reasonPhrase = $reason;

        return $this;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getReasonPhrase(): string
    {
        return $this->reasonPhrase;
    }

    public function cookies(): Cookies
    {
        return $this->cookies;
    }

    public function headers(): Headers
    {
        return $this->headers;
    }
}
