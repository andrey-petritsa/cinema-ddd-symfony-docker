<?php

namespace App\Domain\Booking\Entity\Session;

use App\Domain\Booking\ValueObject\ClientDetails;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/** @ORM\Entity */
class Ticket
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    private UuidInterface $id;

    /** @ORM\ManyToOne(targetEntity="Session", inversedBy="tickets") */
    private Session $session;

    /** @Orm\Embedded(class="App\Domain\Booking\ValueObject\ClientDetails") */
    private ClientDetails $clientDetails;

    public function __construct(UuidInterface $id, Session $session, ClientDetails $clientDetails)
    {
        $this->id = $id;
        $this->session = $session;
        $this->clientDetails = $clientDetails;
    }
}
