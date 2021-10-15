<?php

namespace App\Domain\Booking\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/** @ORM\Entity */
class Movie
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private UuidInterface $id;

    /** @ORM\Column(type="string", length=255) */
    private string $name;

    /** @ORM\Column(type="datetime") */
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
