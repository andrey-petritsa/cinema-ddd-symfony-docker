<?php

namespace App\DataFixtures;

use App\Domain\Booking\Entity\Movie;
use App\Domain\Booking\Entity\Session\Session;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $movies = [
            new Movie(Uuid::uuid4(), 'Тестовый фильм 1', new \DateInterval('PT1H25M')),
            new Movie(Uuid::uuid4(), 'Тестовый фильм 2', new \DateInterval('PT2H10M')),
            new Movie(Uuid::uuid4(), 'Очень долгий фильм', new \DateInterval('PT10H25M'))
        ];
        $entities[] = $movies;

        $sessions = [
            new Session(Uuid::uuid4(), $movies[0], 50, new \DateTime('now')),
            new Session(Uuid::uuid4(), $movies[1], 100, new \DateTime('now')),
            new Session(Uuid::uuid4(), $movies[2], 1, new \DateTime('now')),
        ];
        $entities[] = $sessions;

        $entities = array_merge(...$entities);

        array_walk($entities, fn ($entity) => $manager->persist($entity));
        $manager->flush();
    }
}
