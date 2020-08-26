<?php

namespace Falgun\Http;

interface RequestInterface
{

    public function getMethod(): string;

    public function setMethod(string $method): self;

    public function getBody(): string;

    public function setBody(string $body): self;
}
