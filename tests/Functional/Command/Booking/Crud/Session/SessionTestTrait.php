<?php

namespace App\Tests\Functional\Command\Booking\Crud\Session;

use App\Command\Booking\Crud\Session\ChangeSession\ChangeSessionCommand;
use App\Command\Booking\Crud\Session\CreateSession\CreateSessionCommand;
use App\Domain\Booking\Entity\Session\Session;
use PHPUnit\Framework\Assert;

trait SessionTestTrait
{
    private function assertEqualsCommandWithSession(
        CreateSessionCommand|ChangeSessionCommand $command,
        Session $session
    ) {
        Assert::assertEquals($command->sessionId, $session->getId());
        Assert::assertEquals(new \DateTime($command->startAt), $session->getStartAt());
        Assert::assertEquals($command->movieId, $session->getMovieId());
        Assert::assertEquals($command->numberOfSeats, $session->getNumberOfSeats());
    }
}
