<?php
namespace App\Service;

use Symfony\Component\String\Slugger\SluggerInterface;

class SluggerService
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function generateSlug(string $string): string
    {
        return $this->slugger->slug($string)->lower();
    }
}