<?php

namespace App\Form;

use App\Domain\Booking\Entity\Movie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('movieId', EntityType::class, [
                'class' => Movie::class,
                'choice_label' => 'name',
            ])
            ->add('numberOfSeats', TextType::class)
            ->add('startAt', DateType::class, [
                'input' => 'string',
                'input_format' => 'Y-m-d H:i:s'
            ])
            ->add('save', SubmitType::class);
    }
}
