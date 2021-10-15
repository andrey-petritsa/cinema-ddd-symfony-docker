<?php

namespace App\Domain\Booking\Entity\Session;

use App\Domain\Booking\Collection\TicketCollection;
use App\Domain\Booking\Entity\Movie;
use App\Domain\Booking\TransferObject\TicketInformation;
use App\Domain\Booking\ValueObject\ClientDetails;
use App\Domain\Booking\ValueObject\Phone;
use Ramsey\Uuid\Nonstandard\Uuid;
use Ramsey\Uuid\UuidInterface;

class Session
{
    private TicketCollection $bookedTickets;

    public function __construct(private UuidInterface $id, private Movie $movie, private int $numberOfSeats, private \DateTime $startAt)
    {
        self::assertThatAmountOfSeatsCorrect($numberOfSeats);

        $this->bookedTickets = new TicketCollection();
    }

    public static function assertThatAmountOfSeatsCorrect(int $numberOfSeats)
    {
        if ($numberOfSeats <= 0) {
            throw new \InvalidArgumentException('Количество мест не может быть 0 или меньше');
        }
    }

    public function bookTicket(TicketInformation $ticketInformation)
    {
        $this->assertThatSessionIsNotFull();

        $clientDetails = new ClientDetails($ticketInformation->name, new Phone($ticketInformation->phone));
        $ticket = new Ticket(Uuid::uuid4(), $this, $clientDetails);
        $this->bookedTickets->addTicket($ticket);
    }

    public function assertThatSessionIsNotFull()
    {
        if (empty($this->getNumberOfFreeSeats())) {
            throw new \LogicException('Невозможно добавить билет. Сеанс заполнен');
        }
    }

    public function getMovieName(): string
    {
        return $this->movie->getName();
    }

    public function getNumberOfFreeSeats(): int
    {
        return $this->numberOfSeats - count($this->bookedTickets);
    }

    public function getStartAt(): \DateTime
    {
        return $this->startAt;
    }

    public function getEndAt(): \DateTime
    {
        return $this->startAt->add($this->movie->getDuration());
    }

    public function getMovieDuration(): \DateInterval
    {
        return $this->movie->getDuration();
    }
}
