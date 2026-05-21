<?php

namespace App\Form;

use App\Entity\Actuality;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

class ActualityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                     'placeholder' => "Titre de l'évenement ",
                    ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de rentrer le titre de l\'évenement',
                    ]),
            
                     new Length([
                        'min' => 2,
                        'minMessage' => 'Veuillez rentrer au minimum {{ limit }} lettres',
                        // max length allowed by Symfony for security reasons
                        'max' => 70,
                    ])
                 ]
            ])

            ->add('description', TextType::class, [
                'attr' => [
                     'placeholder' => "descriptif, heure, matériel....",
                    ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de rentrer une desciption de l\'évenement',
                    ]),
            
                     new Length([
                        'min' => 2,
                        'minMessage' => 'Veuillez rentrer au minimum {{ limit }} lettres',
                        // max length allowed by Symfony for security reasons
                        'max' => 255,
                    ])
                 ]
            ])

           ->add('picture', TextType::class, [
                'label' => 'Lien de l\'image (URL)',
                  'attr' => [
                     'placeholder' => "Copier l'adresse de l'image",
                    ],
                'required' => false,
                'constraints' => [
                    new \Symfony\Component\Validator\Constraints\Url([
                        'message' => 'Merci de rentrer une adresse URL valide',
                    ]),
                ]
            ])
            
            ->add('eventOn', DateType::class, [
            'widget' => 'single_text',
            'constraints' => [
                new NotBlank([ 
                    'message'=> 'La date de l\'èvenement est obligatoire',
                ]),
                new GreaterThanOrEqual([
                    'value'=> 'today',
                    'message'=> 'La date de l\'événement doit être supperieur à aujourd\'hui'

                ]),

                ],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Actuality::class,
        ]);
    }
}
