<?php

namespace App\Tests;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class CommandWebTestCase extends KernelTestCase
{
    public static function setUpBeforeClass(): void
    {
        //QUESTION не нашел документации по этому методу
        // Зачем он нужен и почему он вызваетя в setup методе?
        // Возможно, логично загрузить ядро один раз для всего теста как это сделано сейчас??
        self::bootKernel();
    }

    final protected function getMessageBus(): MessageBusInterface
    {
        return self::getContainer()->get('messenger.default_bus');
    }

    final protected function getEntityManager(): EntityManagerInterface
    {
        return self::getContainer()->get(EntityManagerInterface::class);
    }

    final protected function getRandomEntity(string $entityClass)
    {
        return $this->getRepository($entityClass)->findOneBy([]);
    }

    final protected function getRepository($entityClass): ObjectRepository
    {
        return $this->getEntityManager()->getRepository($entityClass);
    }

    final protected function getValidator(): ValidatorInterface
    {
        return self::getContainer()->get('validator');
    }

    final protected function getDatabaseTool()
    {
        return self::getContainer()->get(DatabaseToolCollection::class)->get();
    }
}
