<?php
declare(strict_types=1);

namespace Falgun\Http\Parameters;

class File
{

    protected string $name;
    protected string $type;
    protected string $tmp_name;
    protected int $size;
    protected int $error;

    public function __construct(string $name, string $type, string $tmp_name, int $size, int $error)
    {
        $this->name = $name;
        $this->type = $type;
        $this->tmp_name = $tmp_name;
        $this->size = $size;
        $this->error = $error;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getTmpName(): string
    {
        return $this->tmp_name;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getError(): int
    {
        return $this->error;
    }
}
