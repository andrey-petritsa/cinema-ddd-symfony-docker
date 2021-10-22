<?php

namespace App\Domain\Booking\Entity\Session;

use App\Domain\Booking\Collection\TicketCollection;
use App\Domain\Booking\Entity\Movie;
use App\Domain\Booking\TransferObject\TicketInformation;
use App\Domain\Booking\ValueObject\ClientDetails;
use App\Domain\Booking\ValueObject\Phone;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/** @ORM\Entity */
class Session
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    private UuidInterface $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Domain\Booking\Entity\Movie")
     * @ORM\JoinColumn(name="movie_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private ?Movie $movie;

    /**
     * @ORM\Column(type="integer")
     */
    private int $numberOfSeats;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $startAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Domain\Booking\Entity\Session\Ticket",
     * mappedBy="session", cascade={"persist", "remove"})
     */
    private Collection $bookedTickets;

    public function __construct(UuidInterface $id, ?Movie $movie, int $numberOfSeats, \DateTime $startAt)
    {
        $this->id = $id;
        $this->movie = $movie;
        $this->setNumberOfSeats($numberOfSeats);
        $this->startAt = $startAt;
        $this->bookedTickets = new ArrayCollection();
    }

    public function bookTicket(TicketInformation $ticketInformation)
    {
        $this->assertThatSessionIsNotFull();

        $clientDetails = new ClientDetails($ticketInformation->name, new Phone($ticketInformation->phone));
        $ticket = new Ticket(Uuid::uuid4(), $this, $clientDetails);
        $this->bookedTickets->add($ticket);
    }

    public function rewrite(Movie $movie, int $numberOfSeats, \DateTime $startAt)
    {
        $this->movie = $movie;
        $this->setNumberOfSeats($numberOfSeats);
        $this->startAt = $startAt;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getNumberOfFreeSeats(): int
    {
        return $this->numberOfSeats - count($this->bookedTickets);
    }

    private function setNumberOfSeats($numberOfSeats)
    {
        self::assertThatAmountOfSeatsCorrect($numberOfSeats);

        $this->numberOfSeats = $numberOfSeats;
    }

    public function getNumberOfSeats(): int
    {
        return $this->numberOfSeats;
    }

    public function getStartAt(): \DateTime
    {
        return $this->startAt;
    }

    public function getBookedTickets(): TicketCollection
    {
        return TicketCollection::fromDoctrineCollection($this->bookedTickets);
    }

    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    public function getMovieId(): ?UuidInterface
    {
        return $this->isMovieAnnounced() ? $this->movie->getId() : null;
    }

    public function getMovieName(): ?string
    {
        return $this->isMovieAnnounced() ? $this->movie->getName() : null;
    }

    public function getMovieEndAt(): ?\DateTime
    {
        return $this->isMovieAnnounced() ? $this->startAt->add($this->movie->getDuration()) : null;
    }

    public function getMovieDuration(): ?\DateInterval
    {
        return $this->isMovieAnnounced() ? $this->movie->getDuration() : null;
    }

    public function isMovieAnnounced(): bool
    {
        return !is_null($this->movie);
    }

    private function assertThatSessionIsNotFull()
    {
        if (empty($this->getNumberOfFreeSeats())) {
            throw new \LogicException('Невозможно добавить билет. Сеанс заполнен');
        }
    }

    public static function assertThatAmountOfSeatsCorrect(int $numberOfSeats)
    {
        if ($numberOfSeats <= 0) {
            throw new \InvalidArgumentException('Количество мест не может быть 0 или меньше');
        }
    }
}
