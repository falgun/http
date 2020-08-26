<?php
declare(strict_types=1);

namespace Falgun\Http\Parameters;

abstract class AbstractValueBag implements ValueBagInterface
{

    protected array $values;

    public function __construct(array $values = [])
    {
        $this->values = $values;
    }

    public function all(): array
    {
        return $this->values;
    }

    public function count(): int
    {
        return \count($this->values);
    }

    public function get(string $key, $deafult = null)
    {
        if ($this->has($key)) {
            return $this->values[$key];
        }

        return $deafult;
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->values);
    }

    public function has(string $key): bool
    {
        return \array_key_exists($key, $this->values);
    }

    public function set(string $key, $value): void
    {
        $this->values[$key] = $value;
    }
}
