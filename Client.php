<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\OAuthServerBundle\Entity\Client as BaseClient;
// use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 */
class Client extends BaseClient
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\Column(type="integer", length=30)
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $user;

    public function getPublicId(): ?int
    {
        return $this->id;
    }

    public function setUser(int $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getUser(){
        return $this->user;
    }
}
