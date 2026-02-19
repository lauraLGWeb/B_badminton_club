<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;

class ModifyContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de rentrer votre adresse mail',
                    ]),
                    new Email([
                        'message' => 'L\'adresse email {{ value }} n\'est pas valide',
                    ]),
                ],

            ])
            
            ->add('firstName', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de rentrer votre Prénom',
                    ]),
            
                     new Length([
                        'min' => 2,
                        'minMessage' => 'Veuillez rentrer au minimum {{ limit }} lettres',
                        // max length allowed by Symfony for security reasons
                        'max' => 50,
                    ])
                 ]
            ])

            ->add('lastName', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de rentrer votre Nom',
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Veuillez rentrer au minimum {{ limit }} lettres',
                        // max length allowed by Symfony for security reasons
                        'max' => 50,
                    ])
                 ],
            ])
            
               ->add('lienceNbr', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de rentrer votre numéro de licence',
                    ]),
                    new Regex([
                        'pattern' => '/^\d{7}$/',
                        'message' => 'Le numéro de licence doit contenir exactement 7 chiffres',
                    ]),
                 ],
                ])

                 ->add('roles', ChoiceType::class, [
                        'placeholder' => 'Choisir un statut',
                        'mapped' => false,
                        'choices'  => [
                                'Membre' => "ROLE_MEMBRE",
                                'Administrateur' => "ROLE_ADMIN",
                                'Entraineur' => "ROLE_COACH",
                ],
            ]);
            
           
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
