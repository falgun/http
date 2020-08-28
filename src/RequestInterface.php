<?php

namespace Falgun\Http;

use Falgun\Http\Parameters\Files;
use Falgun\Http\Parameters\Cookies;
use Falgun\Http\Parameters\Headers;
use Falgun\Http\Parameters\PostDatas;
use Falgun\Http\Parameters\QueryDatas;
use Falgun\Http\Parameters\Attributes;
use Falgun\Http\Parameters\ServerDatas;

interface RequestInterface
{

    public function getMethod(): string;

    public function setMethod(string $method): self;

    public function getBody(): string;

    public function setBody(string $body): self;

    public function uri(): Uri;

    public function queryDatas(): QueryDatas;

    public function postDatas(): PostDatas;

    public function attributes(): Attributes;

    public function cookies(): Cookies;

    public function files(): Files;

    public function headers(): Headers;

    public function serverDatas(): ServerDatas;
}
