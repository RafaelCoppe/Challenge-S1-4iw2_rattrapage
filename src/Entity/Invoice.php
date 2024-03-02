<?php

namespace App\Entity;

use App\Repository\InvoiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\Column(length: 255)]
    private ?string $payment_status = null;

    #[ORM\OneToOne(mappedBy: 'invoice', cascade: ['persist', 'remove'])]
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

    #[ORM\OneToMany(mappedBy: 'invoice', targetEntity: Travelers::class, orphanRemoval: true)]
    private Collection $travelers;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    public function __construct()
    {
        $this->travelers = new ArrayCollection();
    }

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

    public function getPaymentStatus(): ?string
    {
        return $this->payment_status;
    }

    public function setPaymentStatus(?string $payment_status): static
    {
        $this->payment_status = $payment_status;

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
            $this->quote->setInvoice(null);
        }

        // set the owning side of the relation if necessary
        if ($quote !== null && $quote->getInvoice() !== $this) {
            $quote->setInvoice($this);
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

    /**
     * @return Collection<int, Travelers>
     */
    public function getTravelers(): Collection
    {
        return $this->travelers;
    }

    public function addTraveler(Travelers $traveler): static
    {
        if (!$this->travelers->contains($traveler)) {
            $this->travelers->add($traveler);
            $traveler->setInvoice($this);
        }

        return $this;
    }

    public function removeTraveler(Travelers $traveler): static
    {
        if ($this->travelers->removeElement($traveler)) {
            // set the owning side to null (unless already changed)
            if ($traveler->getInvoice() === $this) {
                $traveler->setInvoice(null);
            }
        }

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }
}
