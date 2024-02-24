<?php

namespace App\Entity;

use App\Repository\QuotationRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuotationRepository::class)]
class Quotation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $terms = null;

    #[ORM\Column]
    private ?string $status = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $start_date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $end_date = null;

    #[ORM\OneToMany(mappedBy: 'quote', targetEntity: Line::class, fetch: "EAGER")]
    private Collection $lines;

    #[ORM\OneToOne(inversedBy: 'invoice', cascade: ['persist', 'remove'])]
    private ?Invoice $invoice = null;

    #[ORM\OneToOne(mappedBy: 'quotation', cascade: ['persist', 'remove'])]
    private ?Client $client = null;

    #[ORM\Column]
    private ?int $duration = null;

    #[ORM\ManyToOne(fetch: "EAGER", inversedBy: 'quotations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Agency $agency = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $ref = null;

    public function __construct()
    {
        $this->lines = new ArrayCollection();
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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getStartDate(): ?DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(DateTimeInterface $start_date): static
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(DateTimeInterface $end_date): static
    {
        $this->end_date = $end_date;

        return $this;
    }

    /**
     * @return Collection<int, Line>
     */
    public function getLines(): Collection
    {
        return $this->lines;
    }

    public function addLine(Line $line): static
    {
        if (!$this->lines->contains($line)) {
            $this->lines->add($line);
            $line->setQuote($this);
        }

        return $this;
    }

    public function removeLine(Line $line): static
    {
        if ($this->lines->removeElement($line)) {
            // set the owning side to null (unless already changed)
            if ($line->getQuote() === $this) {
                $line->setQuote(null);
            }
        }

        return $this;
    }

    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(?Invoice $invoice): static
    {
        $this->invoice = $invoice;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(Client $client): static
    {
        // set the owning side of the relation if necessary
        if ($client->getQuotation() !== $this) {
            $client->setQuotation($this);
        }

        $this->client = $client;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getAgency(): ?Agency
    {
        return $this->agency;
    }

    public function setAgency(?Agency $agency): static
    {
        $this->agency = $agency;

        return $this;
    }

    public function getRef(): ?string
    {
        return $this->ref;
    }

    public function setRef(?string $ref): static
    {
        $this->ref = $ref;

        return $this;
    }
}
