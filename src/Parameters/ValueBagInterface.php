<?php

namespace Falgun\Http\Parameters;

interface ValueBagInterface extends \IteratorAggregate, \Countable
{

    public function all(): array;

    public function has(string $key): bool;

    /**
     * 
     * @param string $key
     * @param mixed $deafult
     * @return mixed
     */
    public function get(string $key, $deafult = null);

    public function set(string $key, $value): void;
}
