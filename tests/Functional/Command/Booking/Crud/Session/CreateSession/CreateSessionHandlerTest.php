<?php

namespace App\Tests\Functional\Command\Booking\Crud\Session\CreateSession;

use App\Command\Booking\Crud\Session\CreateSession\CreateSessionCommand;
use App\DataFixtures\TestSessionFixtures;
use App\Domain\Booking\Entity\Movie;
use App\Domain\Booking\Entity\Session\Session;
use App\Tests\Functional\Command\Booking\Crud\Session\SessionTestTrait;
use App\Tests\Functional\CommandWebTestCase;
use Ramsey\Uuid\Uuid;

class CreateSessionHandlerTest extends CommandWebTestCase
{
    use SessionTestTrait;

    /** @test */
    public function commandToCreateSessionHandled()
    {
        $this->getDatabaseTool()->loadFixtures([TestSessionFixtures::class]);
        $existedMovie = $this->getOneEntity(Movie::class);

        $createSessionCommand = new CreateSessionCommand(Uuid::uuid4());
        $createSessionCommand->startAt = '2021-02-02 16:15:00';
        $createSessionCommand->numberOfSeats = 25;
        $createSessionCommand->movieId = $existedMovie->getId();

        $this->getMessageBus()->dispatch($createSessionCommand);
        $createdSession = $this->getRepository(Session::class)->find($createSessionCommand->sessionId);

        $this->assertEqualsCommandWithSession($createSessionCommand, $createdSession);
    }
}
