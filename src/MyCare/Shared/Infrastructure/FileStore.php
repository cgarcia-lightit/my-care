<?php

declare(strict_types=1);

namespace MyCare\Shared\Infrastructure;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

final class FileStore implements StorageInterface
{
    /**
     * @param  string $path
     * @return string
     */
    public function get(string$path) : string
    {
        return Storage::get($path);
    }

    /**
     * @param  string $path
     * @param  mixed  $contents
     * @param  array  $options
     * @return bool
     */
    public function put(string $path,mixed $contents,array $options = []): bool
    {
        return Storage::put($path, $contents, $options);
    }

    /**
     * @param  string $path
     * @return StreamedResponse
     */
    public function download(string $path): StreamedResponse
    {
        return Storage::download($path);
    }
}
