<?php

namespace App\Tests\Functional\Command\Booking\Crud\Movie\CreateMovie;

use App\Command\Booking\Crud\Movie\CreateMovie\CreateMovieCommand;
use App\Domain\Booking\Entity\Movie;
use App\Tests\Functional\Command\Booking\Crud\Movie\MovieTestTrait;
use App\Tests\Functional\CommandWebTestCase;
use Ramsey\Uuid\Uuid;

class CreateMovieHandlerTest extends CommandWebTestCase
{
    use MovieTestTrait;

    /** @test */
    public function canHandleCreateMovie()
    {
        $createMovieCommand = new CreateMovieCommand(Uuid::uuid4());
        $createMovieCommand->name = 'Тестовый фильм';
        $createMovieCommand->duration = 'PT2H1M';

        $this->getMessageBus()->dispatch($createMovieCommand);
        $createdMovie = $this->getRepository(Movie::class)->find($createMovieCommand->movieId);

        $this->assertEqualsCommandWithMovie($createMovieCommand, $createdMovie);
    }
}

/**QUESTION
 *  по умолчанию база не обнуляется при запуске каждого теста.
 *  это поведение нужно настроить, чтобы даже без загрузки фикстуры база обнулялась?
 *  Может возникнуть проблема, если, скажем запустить тест canHandleCreateMovie() 100 раз.
 *  После этой операции в тестовой базе будет 100 фильмов. Они уйдут из базы только тогда,
 *  Когда какой нибудь другой тест запустит любую фикстуру (запуск фикстуры очищает всю бд)
 */
