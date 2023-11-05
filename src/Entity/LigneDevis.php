<?php

namespace App\Entity;

use App\Entity\Trait\ligneTrait;
use App\Repository\LigneDevisRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LigneDevisRepository::class)]
class LigneDevis
{
    use ligneTrait;
}
