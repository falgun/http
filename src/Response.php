<?php
declare(strict_types=1);

namespace Falgun\Http;

use Falgun\Http\Parameters\Cookies;
use Falgun\Http\Parameters\Headers;

class Response implements ResponseInterface
{

    public Headers $headers;
    public Cookies $cookies;
    protected string $body;
    protected int $statusCode;
    protected string $reasonPhrase;

    public function __construct(string $body = '', int $statusCode = 200, string $reasonPhrase = '')
    {

        $this->headers = new Headers();
        $this->cookies = new Cookies();
        $this->body = $body;
        $this->statusCode = $statusCode;
        $this->reasonPhrase = $reasonPhrase;
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
}
