<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\Column]
    private ?string $category = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Line::class)]
    private Collection $lines;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Agency $agency = null;

    #[ORM\Column]
    private ?float $tax = null;

    public function __construct()
    {
        $this->lines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function __toString(): string
    {
        return $this->getLabel();
        return $this->getType();
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): static
    {
        $this->category = $category;

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
            $line->setProduct($this);
        }

        return $this;
    }

    public function removeLine(Line $line): static
    {
        $this->lines->removeElement($line);

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

    public function getTax(): ?float
    {
        return $this->tax;
    }

    public function setTax(float $tax): static
    {
        $this->tax = $tax;

        return $this;
    }
}
