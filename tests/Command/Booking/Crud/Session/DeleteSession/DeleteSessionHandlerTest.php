<?php

namespace App\Tests\Command\Booking\Crud\Session\DeleteSession;

use App\Command\Booking\Crud\Session\DeleteSession\DeleteSessionCommand;
use App\Domain\Booking\Entity\Session\Session;
use App\Tests\CommandWebTestCase;

class DeleteSessionHandlerTest extends CommandWebTestCase
{
    /** @test */
    public function sessionAfterCommandHandleNotExists()
    {
        $existedSession = $this->getRandomEntity(Session::class);
        $command = new DeleteSessionCommand($existedSession->getId());

        $this->getMessageBus()->dispatch($command);

        $haveToBeDeletesSession = $this->getRepository(Session::class)->find($command->sessionId);
        self::assertNull($haveToBeDeletesSession);
    }
}