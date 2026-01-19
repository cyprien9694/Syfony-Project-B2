<?php

namespace App\Form;

use App\Entity\Star;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de l\'étoile',
                'attr' => [
                    'placeholder' => 'Ex : Sirius'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Une description de l\'étoile...'
                ]
            ])
            ->add('image', TextType::class, [
                'label' => 'URL de l\'image',
                'required' => false,
                'attr' => [
                    'placeholder' => 'https://...'
                ]
            ])
        ;
        // NOTE : createdAt n'est plus dans le formulaire pour éviter les erreurs
        // Il sera initialisé automatiquement dans le contrôleur
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Star::class,
        ]);
    }
}
