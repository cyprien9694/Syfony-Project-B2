<?php

namespace Symfony\Component\Form;

abstract class AbstractType
{
    /**
     * Méthode à implémenter pour construire le formulaire
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Cette méthode sera surchargée dans les classes filles
    }

    /**
     * Méthode à implémenter pour configurer les options du formulaire
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        // Cette méthode sera surchargée dans les classes filles
    }
}
