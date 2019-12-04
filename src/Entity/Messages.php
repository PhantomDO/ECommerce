<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MessagesRepository")
 */
class Messages
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $message;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="messages")
     */
    private $user1;

    public function __construct()
    {
        $this->user1 = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUser1(): Collection
    {
        return $this->user1;
    }

    public function addUser1(User $user1): self
    {
        if (!$this->user1->contains($user1)) {
            $this->user1[] = $user1;
        }

        return $this;
    }

    public function removeUser1(User $user1): self
    {
        if ($this->user1->contains($user1)) {
            $this->user1->removeElement($user1);
        }

        return $this;
    }
}
