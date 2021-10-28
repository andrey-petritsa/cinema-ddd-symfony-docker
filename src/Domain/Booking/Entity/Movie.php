<?php

namespace App\Domain\Booking\Entity;

use Doctrine\ORM\Mapping as ORM;
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

    private static function assertThatNameNotEmpty(string $name)
    {
        if (empty($name)) {
            throw new \InvalidArgumentException('Название фильма слишком короткое');
        }
    }

    public function rewrite(string $name, \DateInterval $duration)
    {
        $this->setName($name);
        $this->duration = $duration;
    }

    private function setName(string $name)
    {
        self::assertThatNameNotEmpty($name);

        $this->name = $name;
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
