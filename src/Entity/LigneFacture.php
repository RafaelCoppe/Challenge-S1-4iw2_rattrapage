<?php

namespace App\Entity;

use App\Entity\Trait\ligneTrait;
use App\Repository\LigneFactureRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LigneFactureRepository::class)]
class LigneFacture
{
    use ligneTrait;
}
