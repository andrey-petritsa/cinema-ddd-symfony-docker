<?php

namespace App\Domain\Booking\ValueObject;

class ClientDetails
{
    private string $name;

    public function __construct(string $name, private Phone $phone)
    {
        self::assertThatNameNotEmpty($name);
        $this->name = $name;
    }

    public static function assertThatNameNotEmpty($name)
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
