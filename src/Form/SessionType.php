<?php

namespace App\Form;

use App\Domain\Booking\Entity\Movie;
use App\Domain\Booking\Repository\MovieRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class SessionType extends AbstractType
{
    public function __construct(private MovieRepository $movieRepository)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $movies = $this->movieRepository->findAll();
        $movieChoices = array_map(static fn (Movie $movie) => [$movie->getName() => $movie->getId()], $movies);
        $movieChoices = array_merge(...$movieChoices);

        $builder
            ->add('movieId', ChoiceType::class, [
                'label' => 'Фильмы',
                'choices' => $movieChoices,
            ])
            ->add('numberOfSeats', TextType::class)
            ->add('startAt', DateType::class, [
                'input' => 'string',
                'input_format' => 'Y-m-d H:i:s'
            ])
            ->add('save', SubmitType::class)
        ;
    }
}
