<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Nom',
                'attr' => ['placeholder' => 'Votre nom'],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le prénom est obligatoire']),
                    new Assert\Length([
                        'min' => 2,
                        'minMessage' => 'Le prénom doit faire au moins {{ limit }} caractères',
                    ]),
                ],
            ])

            ->add('lastName', TextType::class, [
                'label' => 'Nom',
                'attr' => ['placeholder' => 'Votre nom'],
                'constraints' => [
                    new Assert\NotBlank(['message' => "Le Nom est obligatoire"]),
                    new Assert\Length([
                        'min' => 2,
                        'minMessage' => "Le Nom doit faire au moins {{ limit }} caractères",
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => ['placeholder' => "Votre email"],
                'constraints' => [
                    new Assert\NotBlank(['message' => "L'email est obligatoire"]),
                    new Assert\Email(['message' => "L'email {{ value }} n'est pas valide"]),
                ],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message',
                'attr' => ['placeholder' => 'Votre message', 'rows' => 5],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le message est obligatoire']),
                    new Assert\Length([
                        'min' => 10,
                        'minMessage' => 'Le message doit faire au moins {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('send', SubmitType::class, [
                'label' => 'Envoyer',
            ])
            ->add('reset', ResetType::class, [
                'attr' => ['class' => 'Effacer'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
