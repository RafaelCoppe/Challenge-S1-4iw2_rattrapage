<?php

namespace App\Entity;

use App\Repository\FactureRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FactureRepository::class)]
class Facture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $termes = null;

    #[ORM\ManyToOne(inversedBy: 'factures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FacturePaymentStatus $payment_status = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $start_date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $end_date = null;

    #[ORM\OneToOne(mappedBy: 'Facture', cascade: ['persist', 'remove'])]
    private ?Devis $devis = null;

    #[ORM\Column(length: 255)]
    private ?string $payment_nom = null;

    #[ORM\Column(length: 255)]
    private ?string $payment_prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $payment_email = null;

    #[ORM\Column(length: 255)]
    private ?string $payment_telephone = null;

    #[ORM\Column(length: 255)]
    private ?string $payment_adresse = null;

    #[ORM\Column]
    private ?int $payment_ville = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTermes(): ?string
    {
        return $this->termes;
    }

    public function setTermes(string $termes): static
    {
        $this->termes = $termes;

        return $this;
    }

    public function getPaymentStatus(): ?FacturePaymentStatus
    {
        return $this->payment_status;
    }

    public function setPaymentStatus(?FacturePaymentStatus $payment_status): static
    {
        $this->payment_status = $payment_status;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): static
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): static
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getDevis(): ?Devis
    {
        return $this->devis;
    }

    public function setDevis(?Devis $devis): static
    {
        // unset the owning side of the relation if necessary
        if ($devis === null && $this->devis !== null) {
            $this->devis->setFacture(null);
        }

        // set the owning side of the relation if necessary
        if ($devis !== null && $devis->getFacture() !== $this) {
            $devis->setFacture($this);
        }

        $this->devis = $devis;

        return $this;
    }

    public function getPaymentAddress(): ?string
    {
        return $this->payment_address;
    }

    public function setPaymentAddress(string $payment_address): static
    {
        $this->payment_address = $payment_address;

        return $this;
    }

    public function getPaymentCity(): ?int
    {
        return $this->payment_city;
    }

    public function setPaymentCity(int $payment_city): static
    {
        $this->payment_city = $payment_city;

        return $this;
    }
}
