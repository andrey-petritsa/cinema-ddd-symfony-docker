<?php

namespace App\Tests\Functional\Command\Booking\Crud\Session\ChangeSession;

use App\Command\Booking\Crud\Session\ChangeSession\ChangeSessionCommand;
use App\DataFixtures\TestSessionFixtures;
use App\Domain\Booking\Entity\Movie;
use App\Domain\Booking\Entity\Session\Session;
use App\Tests\Functional\Command\Booking\Crud\Session\SessionTestTrait;
use App\Tests\Functional\CommandWebTestCase;

class ChangeSessionHandlerTest extends CommandWebTestCase
{
    use SessionTestTrait;

    /** @test */
    public function changeSessionHandle()
    {
        $this->getDatabaseTool()->loadFixtures([TestSessionFixtures::class]);
        $existedSession = $this->getOneEntity(Session::class);
        $existedMovie = $this->getOneEntity(Movie::class);

        $changeSessionCommand = new ChangeSessionCommand($existedSession->getId());
        $changeSessionCommand->movieId = $existedMovie->getId();
        $changeSessionCommand->startAt = '2021-02-02 16:15:00';
        $changeSessionCommand->numberOfSeats = 15;

        $this->getMessageBus()->dispatch($changeSessionCommand);

        $this->assertEqualsCommandWithSession($changeSessionCommand, $existedSession);
    }
}
