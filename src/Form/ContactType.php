<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Nom',
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' => 'Votre nom'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' => 'email@example.com'
                ]
            ])
            ->add('subject', null, [
                'label' => 'Sujet',
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' => 'Sujet du message'
                ]
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message',
                'attr' => [
                    'class' => 'form-control mb-3',
                    'rows' => 5,
                    'placeholder' => 'Votre message...'
                ]
            ])
            ->add('send', SubmitType::class, [
                'label' => 'Envoyer',
                'mapped' => false, // 🔥 LA LIGNE QUI BLOQUAIT TOUT
                'attr' => [
                    'class' => 'btn btn-primary mt-3'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
