<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ConvUserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConvUserRepository::class)]
#[ApiResource]
class ConvUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_last_check = null;

    #[ORM\ManyToOne(inversedBy: 'convUsers')]
    private ?User $users = null;

    #[ORM\ManyToOne(inversedBy: 'convUsers')]
    private ?Conv $convs = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateLastCheck(): ?\DateTimeInterface
    {
        return $this->date_last_check;
    }

    public function setDateLastCheck(?\DateTimeInterface $date_last_check): static
    {
        $this->date_last_check = $date_last_check;

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): static
    {
        $this->users = $users;

        return $this;
    }

    public function getConvs(): ?Conv
    {
        return $this->convs;
    }

    public function setConvs(?Conv $convs): static
    {
        $this->convs = $convs;

        return $this;
    }
}
