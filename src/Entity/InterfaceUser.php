<?php

namespace App\Entity;

use App\Repository\InterfaceUserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InterfaceUserRepository::class)]
class InterfaceUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'interfaceUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Boutiques $Boutique = null;

    #[ORM\ManyToOne(inversedBy: 'interfaceUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cloud $Cloud = null;

    #[ORM\ManyToOne(inversedBy: 'interfaceUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Connexion $Connexion = null;

    #[ORM\ManyToOne(inversedBy: 'interfaceUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Mail $Mail = null;

    #[ORM\ManyToOne(inversedBy: 'interfaceUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?QrCode $QrCode = null;

    #[ORM\ManyToOne(inversedBy: 'interfaceUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Telephone $Telephone = null;

    #[ORM\ManyToOne(inversedBy: 'interfaceUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Winparf $Winparf = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Commentaire = null;

    public function __construct()
    {
        if (empty($this->createdAt)){
            $this->createdAt = new \DateTime();
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getBoutique(): ?Boutiques
    {
        return $this->Boutique;
    }

    public function setBoutique(?Boutiques $Boutique): self
    {
        $this->Boutique = $Boutique;

        return $this;
    }

    public function getCloud(): ?Cloud
    {
        return $this->Cloud;
    }

    public function setCloud(?Cloud $Cloud): self
    {
        $this->Cloud = $Cloud;

        return $this;
    }

    public function getConnexion(): ?Connexion
    {
        return $this->Connexion;
    }

    public function setConnexion(?Connexion $Connexion): self
    {
        $this->Connexion = $Connexion;

        return $this;
    }

    public function getMail(): ?Mail
    {
        return $this->Mail;
    }

    public function setMail(?Mail $Mail): self
    {
        $this->Mail = $Mail;

        return $this;
    }

    public function getQrCode(): ?QrCode
    {
        return $this->QrCode;
    }

    public function setQrCode(?QrCode $QrCode): self
    {
        $this->QrCode = $QrCode;

        return $this;
    }

    public function getTelephone(): ?Telephone
    {
        return $this->Telephone;
    }

    public function setTelephone(?Telephone $Telephone): self
    {
        $this->Telephone = $Telephone;

        return $this;
    }

    public function getWinparf(): ?Winparf
    {
        return $this->Winparf;
    }

    public function setWinparf(?Winparf $Winparf): self
    {
        $this->Winparf = $Winparf;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->Commentaire;
    }

    public function setCommentaire(?string $Commentaire): self
    {
        $this->Commentaire = $Commentaire;

        return $this;
    }
}
