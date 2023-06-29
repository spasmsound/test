<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

trait HasId
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'integer')]
    private int $id;

    public function getId(): int
    {
        return $this->id;
    }
}
