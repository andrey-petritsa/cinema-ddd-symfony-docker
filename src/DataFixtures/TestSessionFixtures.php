<?php

namespace App\DataFixtures;

use App\Domain\Booking\Entity\Movie;
use App\Domain\Booking\Entity\Session\Session;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class TestSessionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        /** @var Movie $movie */
        $movie = $this->getReference(TestMovieFixtures::MOVIE_REFERENCE);
        $session = new Session(Uuid::uuid4(), $movie, 1, new \DateTime('now'));

        $manager->persist($session);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            TestMovieFixtures::class,
        ];
    }
}
