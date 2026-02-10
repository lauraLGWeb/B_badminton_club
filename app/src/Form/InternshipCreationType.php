<?php

namespace App\Form;

use App\Entity\Internships;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class InternshipCreationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('internshipTitle', TextType::class, [
                'constraints' => [
                     new Length([
                        'min' => 5,
                        'minMessage' => 'Veuillez rentrer au minimum {{ limit }} lettres',
                        // max length allowed by Symfony for security reasons
                        'max' => 70,
                        ])
                ]
             ])
            ->add('dateTime', DateType::class, [
            'widget' => 'single_text',
            'constraints' => [
                new GreaterThanOrEqual([
                    'value'=> 'today',
                    'message'=> 'La date du stage doit être supperieur à aujourd\'hui'

                ]),

                ],
            ])
            ->add('gymnase', ChoiceType::class, [
                    'choices' => [
                        'Rabelais' => 'Rabelais',
                        'Etelin' => 'Etelin',
                      
                    ],
                    'placeholder' => 'Choisir un gymnase'
            ])
            ->add('price')
            ->add('maxPlayersNbr')
            ->add('alreadyBooked')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Internships::class,
        ]);
    }
}
