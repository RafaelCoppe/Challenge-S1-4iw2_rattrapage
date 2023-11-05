<?php

namespace App\Entity\Trait;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait ligneTrait
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantitee = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private ?string $montantLigne = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantitee(): ?int
    {
        return $this->quantitee;
    }

    public function setQuantitee(int $quantitee): static
    {
        $this->quantitee = $quantitee;

        return $this;
    }

    public function getMontantLigne(): ?string
    {
        return $this->montantLigne;
    }

    public function setMontantLigne(string $montantLigne): static
    {
        $this->montantLigne = $montantLigne;

        return $this;
    }
}
