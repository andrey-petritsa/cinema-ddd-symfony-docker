<?php

namespace App\Domain\Booking\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/** @ORM\Entity */
class Movie
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    private UuidInterface $id;

    /** @ORM\Column(type="string", length=255) */
    private string $name;

    /** @ORM\Column(type="dateinterval") */
    private \DateInterval $duration;

    public function __construct(UuidInterface $id, string $name, \DateInterval $duration)
    {
        $this->id = $id;
        $this->setName($name);
        $this->duration = $duration;
    }

    public static function assertThatNameNotEmpty(string $name)
    {
        if (empty($name)) {
            throw new \InvalidArgumentException('Имя пользователя слишком короткое');
        }
    }

    public function rewrite(string $name, \DateInterval $duration)
    {
        $this->setName($name);
        $this->duration = $duration;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setDuration(\DateInterval $duration): void
    {
        $this->duration = $duration;
    }

    public function setName(string $name)
    {
        //QUESTION можно ли вынести валидацию в этот метод?
        self::assertThatNameNotEmpty($name);

        $this->name = $name;
    }

    public function getDuration(): \DateInterval
    {
        return $this->duration;
    }
}
