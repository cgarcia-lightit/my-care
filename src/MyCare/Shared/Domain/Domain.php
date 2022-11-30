<?php

declare(strict_types=1);

namespace MyCare\Shared\Domain;

abstract class Domain extends Printable
{
    /**
     * @var string[]
     */
    protected array $hidden = [

    ];

    /**
     * @var array
     */
    protected array $events = [];

    abstract function toArray(): array;

    public function pullEvents(): array
    {
        $events = $this->events;
        $this->events = [];
        return $events;

    }

    /**
     * @param $events
     */
    public function pushEvent($events): void
    {
        $this->events = array_merge($this->events, is_array($events) ? $events : [$events]);
    }

    public function hasUnreadEvents(): bool
    {
        return count($this->events) > 0;
    }

    public function toShow(): array
    {
        return array_filter(
            $this->toArray(),
            function ($key) {
                return!in_array($key, $this->hidden);
            },
            ARRAY_FILTER_USE_KEY
        );
    }
}
