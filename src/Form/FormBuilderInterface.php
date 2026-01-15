<?php

namespace Symfony\Component\Form;

interface FormBuilderInterface
{
    public function add(string $name, string $typeClass, array $options = []): self;
}
