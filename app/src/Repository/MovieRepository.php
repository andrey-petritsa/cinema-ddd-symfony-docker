<?php

namespace App\Repository;

use App\Domain\Booking\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class MovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Movie::class);
    }

    public function save(Movie $movie)
    {
        $this->entityManager->persist($movie);
        $this->entityManager->flush();
    }
}
