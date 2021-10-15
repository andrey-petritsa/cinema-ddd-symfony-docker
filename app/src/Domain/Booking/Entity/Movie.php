<?php

namespace App\Domain\Booking\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Ramsey\Uuid\UuidInterface;

/** @Entity */
class Movie
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="UUID")
     */
    private UuidInterface $id;

    /** @Column(type="string", length=255) */
    private string $name;

    /** @Column(type="datetime") */
    private \DateInterval $duration;

    public function __construct(UuidInterface $id, string $name, \DateInterval $duration)
    {
        self::assertThatNameNotEmpty($name);

        $this->id = $id;
        $this->name = $name;
        $this->duration = $duration;
    }

    public static function assertThatNameNotEmpty(string $name)
    {
        if (empty($name)) {
            throw new \InvalidArgumentException('Имя пользователя слишком короткое');
        }
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDuration(): \DateInterval
    {
        return $this->duration;
    }
}
