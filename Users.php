<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 */
class Users
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("grp1")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     *  @Assert\NotBlank(message="The name should not be blank.")
     * @Assert\Length(max=255, maxMessage="The name cannot exceed {{ limit }} characters.")
     * @Groups("grp1")
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"grp2"})
     */
    private $phone;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Groups({"grp2"})
     */
    private $address = [];

    /**
     * @ORM\Column(type="json")
     */
    private $fullname = [];

    /**
     * @ORM\OneToMany(targetEntity=Address::class, mappedBy="addressname")
     */
    private $useraddress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    public function __construct()
    {
        $this->useraddress = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getFullname(): ?array
    {
        return $this->fullname;
    }

    public function setFullname(array $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }

    /**
     * @return Collection<int, Address>
     */
    public function getUseraddress(): Collection
    {
        return $this->useraddress;
    }

    public function addUseraddress(Address $useraddress): self
    {
        if (!$this->useraddress->contains($useraddress)) {
            $this->useraddress[] = $useraddress;
            $useraddress->setAddressname($this);
        }

        return $this;
    }

    public function removeUseraddress(Address $useraddress): self
    {
        if ($this->useraddress->removeElement($useraddress)) {
            // set the owning side to null (unless already changed)
            if ($useraddress->getAddressname() === $this) {
                $useraddress->setAddressname(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
