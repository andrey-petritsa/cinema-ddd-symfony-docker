<?php

namespace App\Domain\Booking\Repository;

use App\Domain\Booking\Entity\Session\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/** * @method Session find($sessionId) */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Session::class);
    }

    public function save(Session $session)
    {
        $this->entityManager->persist($session);
        $this->entityManager->flush();
    }

    public function delete(Session $session)
    {
        $this->entityManager->remove($session);
        $this->entityManager->flush();
    }
}
