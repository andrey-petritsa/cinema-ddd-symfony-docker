<?php

namespace App\Domain\Booking\Collection;

class TicketIterator implements \Iterator
{
    private int $position = 0;

    public function __construct(private TicketCollection $bookedTicketCollection)
    {
    }

    public function current()
    {
        return $this->bookedTicketCollection->getTickets()[$this->position];
    }

    public function next()
    {
        $this->position++;
    }

    public function key(): int
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return isset($this->bookedTicketCollection->getTickets()[$this->position]);
    }

    public function rewind()
    {
        $this->position = 0;
    }
}
