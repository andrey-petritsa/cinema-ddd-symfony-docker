<?php

namespace App\Service;

use App\Domain\Booking\Entity\Movie;
use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;

class MovieService
{
    public function __construct(private MovieRepository $movieRepository)
    {
    }

    public function publishMovie(string $movieName, string $rawMovieDuration)
    {
        $movieDuration = new \DateInterval($rawMovieDuration);
        $movie = new Movie($movieName, $movieDuration);
        $this->movieRepository->save($movie);

        return $movie;
    }
}
