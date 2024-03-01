<?php

namespace App;

use Twig\Extension\AbstractExtension;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Filesystem\Filesystem;

class ImageExtension extends AbstractExtension
{

    public function __construct(#[Autowire('%kernel.debug%')]
                                private $absolutePath
    )
    {}

    public function imageExists(string $imageName): bool
    {
        $filesystem = new Filesystem();
        return $filesystem->exists($this->absolutePath . $imageName);

    }
}
