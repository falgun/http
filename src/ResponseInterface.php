<?php

namespace Falgun\Http;

interface ResponseInterface
{

    public function getBody(): string;

    public function setBody(string $body): self;

    public function setStatusCode(int $code, string $reason = ''): self;

    public function getStatusCode(): int;

    public function getReasonPhrase(): string;
}
