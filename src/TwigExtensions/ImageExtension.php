<?php

namespace App\TwigExtensions;

use Twig\Extension\AbstractExtension;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Filesystem\Filesystem;
use Twig\TwigFunction;

class ImageExtension extends AbstractExtension
{
    public function __construct(
        #[Autowire('%kernel.debug%')]
        private            $absolutePath,
        private FileSystem $filesystem
    )
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('image_exists', [$this, 'imageExists']),
        ];
    }

    public function imageExists(string $imageName): bool
    {
        return $this->filesystem->exists($this->absolutePath . $imageName);
    }
}
