<?php

namespace App\Domain\Booking\ValueObject;

use Doctrine\ORM\Mapping as ORM;

/**  * @ORM\Embeddable */
class ClientDetails
{
    /** @ORM\Column(type = "string", length=255) */
    private string $name;

    /** @Orm\Embedded(class = "Phone") */
    private Phone $phone;

    public function __construct(string $name, Phone $phone)
    {
        self::assertThatNameNotEmpty($name);

        $this->name = $name;
        $this->phone = $phone;
    }

    private static function assertThatNameNotEmpty($name)
    {
        if (empty($name)) {
            throw new \InvalidArgumentException('Имя не может быть пустым');
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPhone(): Phone
    {
        return $this->phone;
    }
}
