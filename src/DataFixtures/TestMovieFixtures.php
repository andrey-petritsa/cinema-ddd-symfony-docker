<?php

namespace App\DataFixtures;

use App\Domain\Booking\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class TestMovieFixtures extends Fixture
{
    public const MOVIE_REFERENCE = 'movie';

    public function load(ObjectManager $manager): void
    {
        /** @var Movie $movie */
        $movie = new Movie(Uuid::uuid4(), 'Тестовый фильм', new \DateInterval('PT1H25M'));
        $manager->persist($movie);
        $manager->flush();
        $this->addReference(self::MOVIE_REFERENCE, $movie);
    }
}

/**QUESTION
 *  Внутри этой фикстуры я хотел создать много фильмов и поместить их в коллекцию.
 *  Эту коллекцию я хотел передать другой фикстуре через $this->>addReference($movies).
 *  Я так понимаю такой подход не практикуется, и addReference используется только на одной сущности?
 */
