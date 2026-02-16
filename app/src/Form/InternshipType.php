<?php

namespace App\Form;

use App\Entity\InternshipPlayer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TelType;

class InternshipType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('SimpleRank', ChoiceType::class, [
                    'choices' => [
                        'NC (Non classé)' => 'NC',
                        'P12' => 'P12',
                        'P11' => 'P11',
                        'P10' => 'P10',
                        'D9'  => 'P9',
                        'D8'  => 'P8',
                        'D7'  => 'P7',
                        'R6'  => 'P6',
                        'R5'  => 'P5',
                        'R4'  => 'P4',
                    ],
                    'placeholder' => 'Choisir un niveau',
                    'attr' => ['class' => 'select-shop']
            ])
            ->add('DoubleRank', ChoiceType::class, [
                    'choices' => [
                        'NC (Non classé)' => 'NC',
                        'P12' => 'P12',
                        'P11' => 'P11',
                        'P10' => 'P10',
                        'D9'  => 'P9',
                        'D8'  => 'P8',
                        'D7'  => 'P7',
                        'R6'  => 'P6',
                        'R5'  => 'P5',
                        'R4'  => 'P4',
                    ],
                    'placeholder' => 'Choisir un niveau',
                    'attr' => ['class' => 'select-shop']
            ])
            ->add('MixteRank', ChoiceType::class, [
                    'choices' => [
                        'NC (Non classé)' => 'NC',
                        'P12' => 'P12',
                        'P11' => 'P11',
                        'P10' => 'P10',
                        'D9'  => 'P9',
                        'D8'  => 'P8',
                        'D7'  => 'P7',
                        'R6'  => 'P6',
                        'R5'  => 'P5',
                        'R4'  => 'P4',
                    ],
                    'placeholder' => 'Choisir un niveau',
                    'attr' => ['class' => 'select-shop']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InternshipPlayer::class,
        ]);
    }
}
