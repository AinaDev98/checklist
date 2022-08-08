<?php

namespace App\Entity;

use App\Repository\CloudRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CloudRepository::class)]
class Cloud
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'Cloud', targetEntity: InterfaceUser::class)]
    private Collection $interfaceUsers;

    public function __construct()
    {
        $this->interfaceUsers = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->nom;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, InterfaceUser>
     */
    public function getInterfaceUsers(): Collection
    {
        return $this->interfaceUsers;
    }

    public function addInterfaceUser(InterfaceUser $interfaceUser): self
    {
        if (!$this->interfaceUsers->contains($interfaceUser)) {
            $this->interfaceUsers[] = $interfaceUser;
            $interfaceUser->setCloud($this);
        }

        return $this;
    }

    public function removeInterfaceUser(InterfaceUser $interfaceUser): self
    {
        if ($this->interfaceUsers->removeElement($interfaceUser)) {
            // set the owning side to null (unless already changed)
            if ($interfaceUser->getCloud() === $this) {
                $interfaceUser->setCloud(null);
            }
        }

        return $this;
    }
}
