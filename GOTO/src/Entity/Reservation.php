<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\DateType;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="date")
     */
    private $Date;

    /**
     * @ORM\Column(type="time")
     */
    private $Heure;

    /**
     * @ORM\Column(type="integer")
     *  @Assert\Positive
     */
    private $Nbrpersonnes;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Vip;

    /**
     * @ORM\Column(type="integer")
     * @Assert\PositiveOrZero
     */
    private $Nbrbebes;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Statut;

    /**
     * @ORM\ManyToOne(targetEntity=Lieu::class, inversedBy="reservations")
     */
    private $lieu;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
    }

    public function getHeure(): ?\DateTimeInterface
    {
        return $this->Heure;
    }

    public function setHeure(\DateTimeInterface $Heure): self
    {
        $this->Heure = $Heure;

        return $this;
    }

    public function getNbrpersonnes(): ?int
    {
        return $this->Nbrpersonnes;
    }

    public function setNbrpersonnes(int $Nbrpersonnes): self
    {
        $this->Nbrpersonnes = $Nbrpersonnes;

        return $this;
    }

    public function getVip(): ?bool
    {
        return $this->Vip;
    }

    public function setVip(bool $Vip): self
    {
        $this->Vip = $Vip;

        return $this;
    }

    public function getNbrbebes(): ?int
    {
        return $this->Nbrbebes;
    }

    public function setNbrbebes(int $Nbrbebes): self
    {
        $this->Nbrbebes = $Nbrbebes;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->Statut;
    }

    public function setStatut(string $Statut): self
    {
        $this->Statut = $Statut;

        return $this;
    }

    public function getLieu(): ?Lieu
    {
        return $this->lieu;
    }

    public function setLieu(?Lieu $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }
    public static function loadValidatorMetadanombrebebe(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('siblings', new Assert\PositiveOrZero());
    }
    public static function loadValidatorMetadanombrepersonne(ClassMetadata $metadata){
        $metadata->addPropertyConstraints('income',new Assert\Positive());
    }
    /*public static function loadValidatorMetadataDate(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('Date', new Assert\GreaterThanOrEqual('22-02-22'));
    }
    */

}
