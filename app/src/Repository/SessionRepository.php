<?php

namespace App\Repository;

use App\Domain\Booking\Entity\Movie;
use App\Domain\Booking\Entity\Session\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class SessionRepository extends ServiceEntityRepository
{
    //TODO Разобраться, сработает ли TicketCollection. Скорее всего нет.
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
