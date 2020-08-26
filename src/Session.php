<?php
declare(strict_types=1);

namespace Falgun\Http;

class Session extends NativeSessionApi implements \IteratorAggregate, \Countable
{

    public function __construct()
    {
        
    }

    public function hasStarted(): bool
    {
        return $this->status() === \PHP_SESSION_ACTIVE;
    }

    public function start(array $options = []): bool
    {
        if ($this->hasStarted()) {
            return true;
        }

        return parent::start($options);
    }

    public function startAsReadOnly(array $options = []): bool
    {
        $newOptions = \array_merge($options, ['read_and_close' => true]);

        return $this->start($newOptions);
    }

    public function stop(): bool
    {
        return parent::writeClose();
    }

    public function has(string $key): bool
    {
        return \array_key_exists($key, $_SESSION);
    }

    public function get(string $key)
    {
        if ($this->has($key)) {
            return $_SESSION[$key];
        }

        throw new \Exception('Session not found for key: ' . $key);
    }

    public function set(string $key, $value): self
    {
        $_SESSION[$key] = $value;

        return $this;
    }

    public function remove(string $key): self
    {
        unset($_SESSION[$key]);

        return $this;
    }

    public function count(): int
    {
        return \count($_SESSION);
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($_SESSION);
    }
}
