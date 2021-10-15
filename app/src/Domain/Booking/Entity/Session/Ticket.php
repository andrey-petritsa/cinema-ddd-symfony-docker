<?php

namespace App\Domain\Booking\Entity\Session;

use App\Domain\Booking\ValueObject\ClientDetails;
use Ramsey\Uuid\UuidInterface;

class Ticket
{
    public function __construct(private UuidInterface $id, private Session $session, private ClientDetails $clientDetails)
    {
    }
}
