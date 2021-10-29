<?php

namespace App\Tests\Domain\Booking\Entity\Session;

use App\Domain\Booking\Collection\TicketCollection;
use App\Domain\Booking\Entity\Movie;
use App\Domain\Booking\Entity\Session\Session;
use App\Domain\Booking\TransferObject\TicketInformation;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class SessionTest extends TestCase
{
    private static UuidInterface $entityId;
    private static \DateTime $nowDateTime;

    public static function setUpBeforeClass(): void
    {
        self::$entityId = Uuid::uuid4();
        self::$nowDateTime = new \DateTime('now');
    }

    /** @test */
    public function cantCreateSessionWithZeroNumberOfSeats()
    {
        $this->expectException(\InvalidArgumentException::class);

        $zeroNumberOfSeats = 0;
        $session = new Session(self::$entityId, null, $zeroNumberOfSeats, self::$nowDateTime);
    }

    /** @test */
    public function cantCreateSessionWithNegativeNumberOfSeats()
    {
        $this->expectException(\InvalidArgumentException::class);

        $negativeNumberOfSeats = -1;
        $session = new Session(self::$entityId, null, $negativeNumberOfSeats, self::$nowDateTime);
    }

    /** @test */
    public function cantBookTicketIfSessionFull()
    {
        $this->expectException(\LogicException::class);

        $twoSeats = 2;
        $session = new Session(self::$entityId, null, $twoSeats, self::$nowDateTime);
        $ticketInformation = new TicketInformation('Андрей', '12345');

        $session->bookTicket($ticketInformation);
        $session->bookTicket($ticketInformation);
        $session->bookTicket($ticketInformation);
    }

    /** @test */
    public function cantRewriteSessionWithZeroSeats()
    {
        $this->expectException(\LogicException::class);

        $positiveSeats = 15;
        $zeroSeats = 0;
        $session = new Session(self::$entityId, null, $positiveSeats, self::$nowDateTime);
        $session->rewrite(null, $zeroSeats, self::$nowDateTime);
    }

    /** @test */
    public function cantRewriteSessionWithNegativeSeats()
    {
        $this->expectException(\LogicException::class);

        $positiveSeats = 15;
        $negativeSeats = -15;
        $session = new Session(self::$entityId, null, $positiveSeats, self::$nowDateTime);
        $session->rewrite(null, $negativeSeats, self::$nowDateTime);
    }

    /** @test */
    public function correctCalculateFreeSeatsAfterBookTicket()
    {
        $numberOfSeats = 5;
        $session = new Session(self::$entityId, null, $numberOfSeats, self::$nowDateTime);
        $ticketInformation = new TicketInformation('Андей', '735735');

        $session->bookTicket($ticketInformation);
        $session->bookTicket($ticketInformation);

        $this->assertEquals(3, $session->getNumberOfFreeSeats());
    }

    /** @test */
    public function sessionMovieAnnounced()
    {
        $movie = new Movie(self::$entityId, 'Девчата', new \DateInterval('PT1H1M'));
        $session = new Session(self::$entityId, $movie, 5, self::$nowDateTime);

        self::assertTrue($session->isMovieAnnounced());
    }

    /** @test */
    public function sessionMovieNotAnnounced()
    {
        $movie = null;
        $session = new Session(self::$entityId, $movie, 5, self::$nowDateTime);

        self::assertFalse($session->isMovieAnnounced());
    }

    /** @test */
    public function informationAboutMovieNullIfMovieNotAnnounced()
    {
        $movie = null;
        $session = new Session(self::$entityId, $movie, 5, self::$nowDateTime);

        self::assertNull($session->getMovie());
        self::assertNull($session->getMovieId());
        self::assertNull($session->getMovieName());
        self::assertNull($session->getMovieEndAt());
        self::assertNull($session->getMovieDuration());
    }

    /** @test */
    public function informationAboutMovieNotNullIfMovieAnnounced()
    {
        $movie = new Movie(self::$entityId, 'Девчата', new \DateInterval('PT1H1M'));
        $session = new Session(self::$entityId, $movie, 5, self::$nowDateTime);

        self::assertNotNull($session->getMovie());
        self::assertNotNull($session->getMovieId());
        self::assertNotNull($session->getMovieName());
        self::assertNotNull($session->getMovieEndAt());
        self::assertNotNull($session->getMovieDuration());
    }

    /** @test */
    public function bookedTicketsIsTicketCollection()
    {
        $session = new Session(self::$entityId, null, 5, self::$nowDateTime);
        self::assertInstanceOf(TicketCollection::class, $session->getBookedTickets());
    }
}
