<?php

namespace App\Tests\Command\Booking\Crud\Session\CreateSession;

use App\Command\Booking\Crud\Session\CreateSession\CreateSessionCommand;
use App\Domain\Booking\Entity\Movie;
use App\Domain\Booking\Entity\Session\Session;
use App\Tests\Command\Booking\Crud\Session\SessionTestTrait;
use App\Tests\CommandWebTestCase;
use Ramsey\Uuid\Uuid;

class CreateSessionHandlerTest extends CommandWebTestCase
{
    use SessionTestTrait;

    /** @test */
    public function commandToCreateMovieHandled()
    {
        $existedMovie = $this->getRandomEntity(Movie::class);

        $createSessionCommand = new CreateSessionCommand(Uuid::uuid4());
        $createSessionCommand->startAt = '2021-02-02 16:15:00';
        $createSessionCommand->numberOfSeats = 25;
        $createSessionCommand->movieId = $existedMovie->getId();

        $this->getMessageBus()->dispatch($createSessionCommand);
        $createdSession = $this->getRepository(Session::class)->find($createSessionCommand->sessionId);

        $this->assertEqualsCommandWithSession($createSessionCommand, $createdSession);
    }
}