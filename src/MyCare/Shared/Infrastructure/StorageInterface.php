<?php

declare(strict_types=1);

namespace MyCare\Shared\Infrastructure;

interface StorageInterface
{

    public function get(string $path);

    public function put(string $path, mixed $contents, array $options = []);

    public function download(string $path);
}
