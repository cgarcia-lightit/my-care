<?php

declare(strict_types=1);

namespace MyCare\Shared\Domain\ValueObj;

use Exception;
use InvalidArgumentException;

final class Identifier
{
    /**
     * @throws Exception
     */
    public function __construct(private string $id = '')
    {
        if (!empty($this->id)) {
            $this->validateId($id);
        } else {

            $data = random_bytes(16);
            $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // Set version to 0100
            $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

            $this->id = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
        }
    }

    public function __toString(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function __invoke()
    {
        return $this->id;
    }

    private function validateId(string $id): void
    {

        if (strlen($id) !== 36) {
            throw new InvalidArgumentException(
                "Identifier must be at 36 characters long, got '$id'",
            );
        }

        if (is_numeric($id)) {
            throw new InvalidArgumentException(
                'Identifier must not be only numeric characters'
            );
        }

        if (ctype_alpha($id)) {
            throw new InvalidArgumentException(
                'Identifier must not contain only letters'
            );
        }
    }

    /**
     * @return string
     */
    public function get()
    {
        return $this->id;
    }
}
