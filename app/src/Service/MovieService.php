<?php

namespace App\Service;

use App\Domain\Booking\Entity\Movie;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;

class MovieService
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function publishMovie(string $movieName, string $rawMovieDuration)
    {
        $movieDuration = new \DateInterval($rawMovieDuration);
        $movie = new Movie($movieName, $movieDuration);

        $this->entityManager->persist($movie);
        $this->entityManager->flush();

        return $movie;
    }
}
