<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('duration', DateIntervalType::class, [
                'with_years' => false,
                'with_months' => false,
                'with_days' => false,
                'with_hours' => true,
                'with_minutes' => true,
                'input' => 'string'
            ])
            ->add('save', SubmitType::class);
    }
}
