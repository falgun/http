<?php

namespace Falgun\Http;

use Falgun\Http\Parameters\Cookies;
use Falgun\Http\Parameters\Headers;

interface ResponseInterface
{

    public function getBody(): string;

    public function setBody(string $body): self;

    public function setStatusCode(int $code, string $reason = ''): self;

    public function getStatusCode(): int;

    public function getReasonPhrase(): string;

    public function cookies(): Cookies;

    public function headers(): Headers;
}
