<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ConvRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConvRepository::class)]
#[ApiResource]
class Conv
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_last_message = null;

    /**
     * @var Collection<int, ConvUser>
     */
    #[ORM\OneToMany(targetEntity: ConvUser::class, mappedBy: 'convs')]
    private Collection $convUsers;

    /**
     * @var Collection<int, Message>
     */
    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'convs')]
    private Collection $messages;

    public function __construct()
    {
        $this->convUsers = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateLastMessage(): ?\DateTimeInterface
    {
        return $this->date_last_message;
    }

    public function setDateLastMessage(?\DateTimeInterface $date_last_message): static
    {
        $this->date_last_message = $date_last_message;

        return $this;
    }

    /**
     * @return Collection<int, ConvUser>
     */
    public function getConvUsers(): Collection
    {
        return $this->convUsers;
    }

    public function addConvUser(ConvUser $convUser): static
    {
        if (!$this->convUsers->contains($convUser)) {
            $this->convUsers->add($convUser);
            $convUser->setConvs($this);
        }

        return $this;
    }

    public function removeConvUser(ConvUser $convUser): static
    {
        if ($this->convUsers->removeElement($convUser)) {
            // set the owning side to null (unless already changed)
            if ($convUser->getConvs() === $this) {
                $convUser->setConvs(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): static
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setConvs($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): static
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getConvs() === $this) {
                $message->setConvs(null);
            }
        }

        return $this;
    }
}
