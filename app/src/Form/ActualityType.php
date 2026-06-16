<?php

namespace App\Form;

use App\Entity\Actuality;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ActualityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'placeholder' => "Titre de l'évenement",
                ],
                'constraints' => [
                    new NotBlank(message: 'Merci de rentrer le titre de l\'évenement'),
                    new Length(min: 2, max: 100, minMessage: 'Veuillez rentrer au minimum {{ limit }} lettres'),
                ],
            ])

            ->add('description', TextType::class, [
                'attr' => [
                    'placeholder' => "Descriptif, heure, matériel...",
                ],
                'constraints' => [
                    new NotBlank(message: 'Merci de rentrer une description de l\'évenement'),
                    new Length(min: 2, max: 255, minMessage: 'Veuillez rentrer au minimum {{ limit }} lettres'),
                ],
            ])

            ->add('picture', TextType::class, [
                'label' => 'Lien de l\'image (URL internet)',
                'attr' => [
                    'placeholder' => "https://...",
                ],
                'required' => false,
                'empty_data' => null,
                'constraints' => [
                    new Url(message: 'Merci de rentrer une adresse URL valide', requireTld: false),
                ],
            ])

            ->add('pictureFile', FileType::class, [
                'label' => 'Ou uploader une image depuis votre ordinateur',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File(
                        maxSize: '5M',
                        mimeTypes: ['image/jpeg', 'image/png', 'image/webp', 'image/gif'],
                        mimeTypesMessage: 'Merci de choisir une image valide (jpg, png, webp, gif)',
                        maxSizeMessage: 'L\'image ne doit pas dépasser 5 Mo',
                    ),
                ],
            ])

            ->add('eventOn', DateType::class, [
                'widget' => 'single_text',
                'constraints' => [
                    new NotBlank(message: 'La date de l\'événement est obligatoire'),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Actuality::class,
        ]);
    }
}
