<?php

declare(strict_types=1);

namespace MyCare\Shared\Domain;

use Illuminate\Database\Eloquent\JsonEncodingException;
use JsonSerializable;

abstract class Printable implements JsonSerializable
{
    abstract function toArray(): array;

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toJson(int $options = 0): bool|string
    {
        $json = json_encode($this->jsonSerialize(), $options);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw JsonEncodingException::forModel($this, json_last_error_msg());
        }

        return $json;
    }

    public function __toString(): string
    {
        return $this->toJson(JSON_PRETTY_PRINT);
    }
}
