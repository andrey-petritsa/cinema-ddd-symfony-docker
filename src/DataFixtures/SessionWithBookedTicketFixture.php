<?php

namespace App\DataFixtures;

use App\Domain\Booking\Entity\Movie;
use App\Domain\Booking\Entity\Session\Session;
use App\Domain\Booking\TransferObject\TicketInformation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class SessionWithBookedTicketFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        /** @var Movie $movie */
        $movie = $this->getReference(TestMovieFixtures::MOVIE_REFERENCE);
        $session = new Session(Uuid::uuid4(), $movie, 5, new \DateTime('now'));
        $session->bookTicket(new TicketInformation('Андрей', '735735'));
        $manager->persist($session);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            TestMovieFixtures::class
        ];
    }
}
