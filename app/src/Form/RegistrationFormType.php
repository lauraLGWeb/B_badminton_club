<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;


// already XSS protection in symfony 

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => [
                    
                    new Email([
                        'message' => 'L\'adresse email {{ value }} n\'est pas valide',
                    ]),
                ]

            ])
            
            ->add('firstName', TextType::class, [
                'constraints' => [
                
                     new Length([
                        'min' => 2,
                        'minMessage' => 'Minimum {{ limit }} lettres',
                        // max length allowed by Symfony for security reasons
                        'max' => 50,
                    ])
                 ],
            ])

            ->add('lastName', TextType::class, [
                'constraints' => [
                    
                     new Length([
                        'min' => 2,
                        'minMessage' => ' Minimum {{ limit }} lettres',
                        
                        'max' => 50,
                    ])
                 ],
            ])
            
            ->add('lienceNbr', TextType::class)

            ->add('phoneNbr', TelType::class)
        
            ->add('agreeTerms', CheckboxType::class, [
                                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Merci d\'accepter les conditions générales.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^(?=.*[A-Z])(?=.*\d).{8,}$/',
                        //regex explanation ^→ start : (?=.*[A-Z]) one maj (?=.*\d) one number .{8,}  at least 8 chars $ end
                        'message' => 'Le mot de passe doit contenir au moins 8 caractères, une majuscule et un chiffre',
                    ]),
                    new NotBlank([
                        'message' => 'Le mot de passe est obligatoire test',

                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
