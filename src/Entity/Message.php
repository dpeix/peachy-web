<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MessageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageRepository::class)]

class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $author = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_post = null;

    #[ORM\Column(length: 255)]
    private ?string $body = null;

    #[ORM\ManyToOne(inversedBy: 'messages')]
    private ?Conv $convs = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getDatePost(): ?\DateTimeInterface
    {
        return $this->date_post;
    }

    public function setDatePost(\DateTimeInterface $date_post): static
    {
        $this->date_post = $date_post;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): static
    {
        $this->body = $body;

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
