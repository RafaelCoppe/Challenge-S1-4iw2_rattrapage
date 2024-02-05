<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[ORM\Column(length: 255)]
    private ?string $tel = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column]
    private ?int $city = null;

    #[ORM\ManyToOne(inversedBy: 'utilisateurs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?UtilisateurGenre $genre = null;

    #[ORM\ManyToOne(inversedBy: 'utilisateurs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?UtilisateurStatus $status = null;

    #[ORM\ManyToOne(inversedBy: 'utilisateurs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?UtilisateurRole $role = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeInterface $create_date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $update_date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $delete_date = null;

    #[ORM\ManyToMany(targetEntity: Agence::class, inversedBy: 'utilisateurs')]
    private Collection $Agence;

    public function __construct()
    {
        $this->Agence = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): static
    {
        $this->tel = $tel;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCity(): ?int
    {
        return $this->city;
    }

    public function setCity(int $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getGenre(): ?UtilisateurGenre
    {
        return $this->genre;
    }

    public function setGenre(?UtilisateurGenre $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function getStatus(): ?UtilisateurStatus
    {
        return $this->status;
    }

    public function setStatus(?UtilisateurStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getRole(): ?UtilisateurRole
    {
        return $this->role;
    }

    public function setRole(?UtilisateurRole $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getCreateDate(): ?DateTimeInterface
    {
        return $this->create_date;
    }

    public function setCreateDate(DateTimeInterface $create_date): static
    {
        $this->create_date = $create_date;

        return $this;
    }

    public function getUpdateDate(): ?DateTimeInterface
    {
        return $this->update_date;
    }

    public function setUpdateDate(?DateTimeInterface $update_date): static
    {
        $this->update_date = $update_date;

        return $this;
    }

    public function getDeleteDate(): ?DateTimeInterface
    {
        return $this->delete_date;
    }

    public function setDeleteDate(?DateTimeInterface $delete_date): static
    {
        $this->delete_date = $delete_date;

        return $this;
    }

    /**
     * @return Collection<int, Agence>
     */
    public function getAgence(): Collection
    {
        return $this->Agence;
    }

    public function addAgence(Agence $agence): static
    {
        if (!$this->Agence->contains($agence)) {
            $this->Agence->add($agence);
        }

        return $this;
    }

    public function removeAgence(Agence $agence): static
    {
        $this->Agence->removeElement($agence);

        return $this;
    }
}
