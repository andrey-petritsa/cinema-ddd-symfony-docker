<?php

namespace App\Domain\Booking\TransferObject;

class MovieDto
{
    public \DateInterval $duration;

    public function __construct(public string $name, public string $rawDuration)
    {
        $this->duration = new \DateInterval($this->rawDuration);
    }
}
