<?php

namespace App\Controller;

use App\Entity\superheroes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class SuperheroBySlug extends AbstractController
{
    public function __invoke(string $slug)
    {
        $superhero = $this->getDoctrine()
            ->getRepository(superheroes::class)
            ->findBy(
                ['slug' => $slug],
            );

        if (!$superhero) {
            throw $this->createNotFoundException(
                'No superhero found for this slug'
            );
        }

        return $superhero;
    }
}