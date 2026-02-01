<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'required' => true,
                'attr' => ['placeholder' => 'Votre nom', 'class' => 'form-control mb-3'],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required' => true,
                'attr' => ['placeholder' => 'email@example.com', 'class' => 'form-control mb-3'],
            ])
            ->add('subject', TextType::class, [
                'label' => 'Sujet',
                'required' => true,
                'attr' => ['placeholder' => 'Sujet du message', 'class' => 'form-control mb-3'],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message',
                'required' => true,
                'attr' => ['placeholder' => 'Votre message...', 'class' => 'form-control mb-3', 'rows' => 5],
            ])
            ->add('send', SubmitType::class, ['label' => 'Envoyer', 'attr' => ['class' => 'btn btn-primary mt-3']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
