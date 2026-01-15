<?php

namespace Symfony\Component\Validator\Constraints;

class File
{
    public string $maxSize;
    public array $mimeTypes;
    public string $mimeTypesMessage;

    public function __construct(array $options = [])
    {
        $this->maxSize = $options['maxSize'] ?? '2M';
        $this->mimeTypes = $options['mimeTypes'] ?? [];
        $this->mimeTypesMessage = $options['mimeTypesMessage'] ?? 'Format non valide';
    }
}
