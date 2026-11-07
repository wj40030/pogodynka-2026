<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city', null, [
                'attr' => [
                    'placeholder' => 'Podaj nazwę miasta',
                ],
            ])
            ->add('country', ChoiceType::class, [
                'choices' => [
                    'Polska' => 'PL',
                    'Niemcy' => 'DE',
                    'Czechy' => 'CZ',
                    'Francja' => 'FR',
                    'Hiszpania' => 'ES',
                ],
                'required' => false,
            ])
            ->add('latitude', NumberType::class, [
                'input' => 'string',
                'scale' => 7,
                'invalid_message' => 'Podaj poprawną liczbę.',
            ])
            ->add('longitude', NumberType::class, [
                'input' => 'string',
                'scale' => 7,
                'invalid_message' => 'Podaj poprawną liczbę.',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
