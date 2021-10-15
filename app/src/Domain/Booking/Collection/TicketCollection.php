<?php

namespace App\Domain\Booking\Collection;

use App\Domain\Booking\Entity\Session\Ticket;

class TicketCollection implements \IteratorAggregate, \Countable
{
    private array $tickets = [];

    public function getIterator(): TicketIterator
    {
        return new TicketIterator($this);
    }

    public function getTickets(): array
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket)
    {
        $this->tickets[] = $ticket;
    }

    public function count(): int
    {
        return count($this->tickets);
    }
}
