<?php

namespace App\Tests\Functional\Command\Booking\Crud\Session\DeleteSession;

use App\Command\Booking\Crud\Session\DeleteSession\DeleteSessionCommand;
use App\DataFixtures\TestSessionFixtures;
use App\Domain\Booking\Entity\Session\Session;
use App\Tests\Functional\CommandWebTestCase;

class DeleteSessionHandlerTest extends CommandWebTestCase
{
    /** @test */
    public function sessionAfterCommandHandleNotExists()
    {
        $this->getDatabaseTool()->loadFixtures([TestSessionFixtures::class]);
        $existedSession = $this->getOneEntity(Session::class);
        $command = new DeleteSessionCommand($existedSession->getId());

        $this->getMessageBus()->dispatch($command);

        $haveToBeDeletesSession = $this->getRepository(Session::class)->find($command->sessionId);
        self::assertNull($haveToBeDeletesSession);
    }
}
