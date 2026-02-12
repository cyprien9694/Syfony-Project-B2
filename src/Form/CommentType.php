<?php
namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextareaType::class, [
                'label' => 'Votre commentaire',
                'constraints' => [
                    new NotBlank(
                        message: 'Veuillez écrire un commentaire'
                    ),
                    new Length(
                        min: 5,
                        max: 1000,
                        minMessage: 'Votre commentaire doit faire au moins {{ limit }} caractères',
                        maxMessage: 'Votre commentaire ne peut pas dépasser {{ limit }} caractères'
                    )
                ],
                'attr' => [
                    'rows' => 3,
                    'placeholder' => 'Écrivez votre commentaire...',
                    'class' => 'form-control'
                ]
            ])
            ->add('image', FileType::class, [
                'label' => 'Image (optionnelle)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File(
                        maxSize: '2M',
                        //mimeTypes: ['image/jpeg', 'image/png', 'image/gif'],
                        //mimeTypesMessage: 'Veuillez uploader une image valide (JPEG, PNG, GIF)'
                    )
                ],
                'attr' => ['class' => 'form-control']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}