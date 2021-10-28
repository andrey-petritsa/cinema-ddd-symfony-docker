<?php

namespace App\Tests\Domain\Booking\Entity;

use App\Domain\Booking\Entity\Movie;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class MovieTest extends TestCase
{
    public function testThatCantCreateMovieWithEmptyValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $emptyMovieName = '';
        $movieDuration = new \DateInterval('PT2H25M');
        $movie = new Movie(Uuid::uuid4(), $emptyMovieName, $movieDuration);
    }

    public function testThatCantRewriteMovieNameToEmptyValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $oldMovieName = 'old name';
        $movieDuration = new \DateInterval('PT2H25M');
        $movie = new Movie(Uuid::uuid4(), $oldMovieName, $movieDuration);

        $movie->rewrite('', $movieDuration);
    }
}
