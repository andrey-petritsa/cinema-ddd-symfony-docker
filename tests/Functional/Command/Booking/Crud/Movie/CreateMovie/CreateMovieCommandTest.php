<?php

namespace App\Tests\Functional\Command\Booking\Crud\Movie\CreateMovie;

use App\Command\Booking\Crud\Movie\CreateMovie\CreateMovieCommand;
use App\Domain\Booking\Entity\Movie;
use App\Tests\Functional\CommandWebTestCase;
use App\Tests\Functional\ObjectPropertyTrait;
use App\Tests\Functional\ViolationAssertTrait;
use Ramsey\Uuid\Uuid;

class CreateMovieCommandTest extends CommandWebTestCase
{
    use ObjectPropertyTrait;
    use ViolationAssertTrait;

    /** @test */
    public function blankCommandInvalid()
    {
        $command = new CreateMovieCommand(Uuid::uuid4());

        $this->setBlankPropertiesTo($command);
        $violations = $this->getValidator()->validate($command);

        foreach ($this->getProperties($command) as $commandProperty) {
            $this->assertPropertyIsInvalid($commandProperty, 'This value should not be blank.', $violations);
        }
    }

    /** @test */
    public function goodCommandValid()
    {
        $command = $this->getGoodCommand();

        $violations = $this->getValidator()->validate($command);

        foreach ($this->getProperties($command) as $property) {
            $this->assertPropertyIsValid($property, $violations);
        }
    }

    private function getGoodCommand()
    {
        $command = new CreateMovieCommand(Uuid::uuid4());
        $command->name = 'Андрей';
        $command->duration = 'PT2H1M';
        $command->movieId = $this->getOneEntity(Movie::class)->getId();

        return $command;
    }
}
