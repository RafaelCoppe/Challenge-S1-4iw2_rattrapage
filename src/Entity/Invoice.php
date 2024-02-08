<?php

namespace App\Entity;

use App\Repository\InvoiceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InvoiceRepository::class)]
class Invoice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $terms = null;

    #[ORM\ManyToOne(inversedBy: 'factures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?InvoicePaymentStatus $payment_status = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $start_date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $end_date = null;

    #[ORM\OneToOne(mappedBy: 'Invoice', cascade: ['persist', 'remove'])]
    private ?Quotation $quote = null;

    #[ORM\Column(length: 255)]
    private ?string $payment_lastname = null;

    #[ORM\Column(length: 255)]
    private ?string $payment_firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $payment_email = null;

    #[ORM\Column(length: 255)]
    private ?string $payment_phone = null;

    #[ORM\Column(length: 255)]
    private ?string $payment_address = null;

    #[ORM\Column]
    private ?int $payment_city = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTerms(): ?string
    {
        return $this->terms;
    }

    public function setTerms(string $terms): static
    {
        $this->terms = $terms;

        return $this;
    }

    public function getPaymentStatus(): ?InvoicePaymentStatus
    {
        return $this->payment_status;
    }

    public function setPaymentStatus(?InvoicePaymentStatus $payment_status): static
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

    public function getQuote(): ?Quotation
    {
        return $this->quote;
    }

    public function setQuote(?Quotation $quote): static
    {
        // unset the owning side of the relation if necessary
        if ($quote === null && $this->quote !== null) {
            $this->quote->setFacture(null);
        }

        // set the owning side of the relation if necessary
        if ($quote !== null && $quote->getFacture() !== $this) {
            $quote->setFacture($this);
        }

        $this->quote = $quote;

        return $this;
    }

    public function getPaymentLastname(): ?string
    {
        return $this->payment_lastname;
    }

    public function setPaymentLastname(?string $payment_lastname): void
    {
        $this->payment_lastname = $payment_lastname;
    }

    public function getPaymentFirstname(): ?string
    {
        return $this->payment_firstname;
    }

    public function setPaymentFirstname(?string $payment_firstname): void
    {
        $this->payment_firstname = $payment_firstname;
    }

    public function getPaymentEmail(): ?string
    {
        return $this->payment_email;
    }

    public function setPaymentEmail(?string $payment_email): void
    {
        $this->payment_email = $payment_email;
    }

    public function getPaymentPhone(): ?string
    {
        return $this->payment_phone;
    }

    public function setPaymentPhone(?string $payment_phone): void
    {
        $this->payment_phone = $payment_phone;
    }

    public function getPaymentAddress(): ?string
    {
        return $this->payment_address;
    }

    public function setPaymentAddress(?string $payment_address): void
    {
        $this->payment_address = $payment_address;
    }

    public function getPaymentCity(): ?int
    {
        return $this->payment_city;
    }

    public function setPaymentCity(?int $payment_city): void
    {
        $this->payment_city = $payment_city;
    }
}
