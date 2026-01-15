<?php

namespace Symfony\Component\OptionsResolver;

class OptionsResolver
{
    private array $defaults = [];

    public function setDefaults(array $defaults): void
    {
        $this->defaults = $defaults;
    }

    public function getDefaults(): array
    {
        return $this->defaults;
    }
}
