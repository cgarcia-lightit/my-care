<?php

declare(strict_types=1);

namespace MyCare\Shared\Application;

final class OutDto
{

    /**
     * @param null $data
     */
    public function __construct(
        private $data = null,
        private int|string $code = 200,
        private string $errorMessage = ''
    ) {
        $isString = is_string($code);
        $isNumeric = is_numeric($code);
        if ($isString && !$isNumeric ) {
            $this->code = 500;
        }

        if ($isString && $isNumeric) {
            $this->code = (int)$code;
        }
    }

    public function getData(): mixed
    {
        return $this->data;
    }

    public function setData(mixed $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function isSuccess(): bool
    {
        return $this->code >= 200 && $this->code < 400;
    }

    public function setSuccess(int $code = 200): self
    {
        $this->setCode($code);
        return $this;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    public function setErrorMessage(string $errorMessage): void
    {
        $this->errorMessage = $errorMessage;
    }

    public function getCode(): int|string
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;
        return $this;
    }


}
