<?php

namespace App\Domain\Booking\ValueObject;

use Doctrine\ORM\Mapping as ORM;

/**  * @ORM\Embeddable */
class Phone
{
    /** @ORM\Column(type = "string", length=255) */
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
