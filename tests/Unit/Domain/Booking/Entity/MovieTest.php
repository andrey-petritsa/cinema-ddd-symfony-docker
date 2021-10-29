<?php

namespace App\Tests\Unit\Domain\Booking\Entity;

use App\Domain\Booking\Entity\Movie;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class MovieTest extends TestCase
{
    /** @test */
    public function cantCreateMovieWithEmptyValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $emptyMovieName = '';
        $movieDuration = new \DateInterval('PT2H25M');
        $movie = new Movie(Uuid::uuid4(), $emptyMovieName, $movieDuration);
    }

    /** @test */
    public function cantRewriteMovieNameToEmptyValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $oldMovieName = 'old name';
        $movieDuration = new \DateInterval('PT2H25M');
        $movie = new Movie(Uuid::uuid4(), $oldMovieName, $movieDuration);

        $movie->rewrite('', $movieDuration);
    }
}
