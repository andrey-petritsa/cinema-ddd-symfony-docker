<?php

namespace App\Domain\Booking\ValueObject;

class Phone
{
    private string $phone;

    public function __construct(string $phone)
    {
        self::assertThatPhoneNumberIsNumeric($phone);
        $this->phone = $phone;
    }

    private static function assertThatPhoneNumberIsNumeric(string $phone)
    {
        if (!is_numeric($phone)) {
            throw new \InvalidArgumentException('Номер телефона указан не верно');
        }
    }
}
