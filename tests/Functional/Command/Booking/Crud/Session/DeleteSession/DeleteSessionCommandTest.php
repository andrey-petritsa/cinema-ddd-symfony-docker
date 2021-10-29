<?php

namespace App\Tests\Functional\Command\Booking\Crud\Session\DeleteSession;

use App\Command\Booking\Crud\Session\DeleteSession\DeleteSessionCommand;
use App\DataFixtures\TestSessionFixtures;
use App\Domain\Booking\Entity\Session\Session;
use App\Tests\Functional\CommandWebTestCase;
use App\Tests\Functional\ViolationAssertTrait;
use Ramsey\Uuid\Uuid;

class DeleteSessionCommandTest extends CommandWebTestCase
{
    use ViolationAssertTrait;

    /** @test */
    public function commandWithNotExistedSessionInvalid()
    {
        $notExistedSessionId = Uuid::uuid4();
        $command = new DeleteSessionCommand($notExistedSessionId);

        $violations = $this->getValidator()->validate($command);

        $this->assertPropertyIsInvalid('sessionId', 'Не удалось найти сессию для удаления', $violations);
    }

    /** @test */
    public function commandWithExistedSessionValid()
    {
        $this->getDatabaseTool()->loadFixtures([TestSessionFixtures::class]);
        $existedSession = $this->getOneEntity(Session::class);
        $command = new DeleteSessionCommand($existedSession->getId());

        $violations = $this->getValidator()->validate($command);

        $this->assertPropertyIsValid('sessionId', $violations);
    }
}
