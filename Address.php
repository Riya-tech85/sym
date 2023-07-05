<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AddressRepository::class)
 */
class Address
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=users::class, inversedBy="useraddress")
     * @ORM\JoinColumn(nullable=false)
     */
    private $addressname;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddressname(): ?users
    {
        return $this->addressname;
    }

    public function setAddressname(?users $addressname): self
    {
        $this->addressname = $addressname;

        return $this;
    }
}
