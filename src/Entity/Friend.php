<?php

namespace App\Entity;

use App\Repository\FriendRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FriendRepository::class)
 */
class Friend
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $targerUser;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $userFriend;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getTargerUser(): ?User
    {
        return $this->targerUser;
    }

    public function setTargerUser(?User $targerUser): self
    {
        $this->targerUser = $targerUser;

        return $this;
    }

    public function getUserFriend(): ?User
    {
        return $this->userFriend;
    }

    public function setUserFriend(?User $userFriend): self
    {
        $this->userFriend = $userFriend;

        return $this;
    }
}
