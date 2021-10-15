<?php

namespace App\Domain\Booking\TransferObject;

class TicketInformation
{
    public function __construct(public string $name, public string $phone)
    {
    }
}
