<?php
// src/Form/CommentType.php
namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface; // IMPORTANT
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextareaType::class, [
                'attr' => ['placeholder' => 'Écrire un commentaire...']
            ])
            ->add('category', ChoiceType::class, [
                'choices' => [
                    '⭐ Étoile' => 'star',
                    '✨ Constellation' => 'constellation',
                    '🌌 Galaxie' => 'galaxy'
                ]
            ])
            ->add('image', FileType::class, [
                'required' => false,
                'mapped' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}