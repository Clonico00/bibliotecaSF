<?php

namespace App\Entity;

use App\Repository\PrestamoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: PrestamoRepository::class)]
class Prestamo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Socio $socio = null;

    /*@ORM\ManyToOne(targetEntity=Ejemplar::class, inversedBy="prestamos", cascade={"persist"})

     * */
    #[ORM\ManyToOne (targetEntity: Ejemplar::class, cascade: ["persist"], inversedBy: "prestamos")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ejemplar $ejemplar = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha_devolucion = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha_retiro = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSocio(): ?Socio
    {
        return $this->socio;
    }

    public function setSocio(?Socio $socio): self
    {
        $this->socio = $socio;

        return $this;
    }

    public function getEjemplar(): ?Ejemplar
    {
        return $this->ejemplar;
    }

    public function setEjemplar(Ejemplar $ejemplar): self
    {
        $this->ejemplar = $ejemplar;

        return $this;
    }

    public function getFechaDevolucion(): ?\DateTimeInterface
    {
        return $this->fecha_devolucion;
    }

    public function setFechaDevolucion(\DateTimeInterface $fecha_devolucion): self
    {
        $this->fecha_devolucion = $fecha_devolucion;

        return $this;
    }

    public function getFechaRetiro(): ?\DateTimeInterface
    {
        return $this->fecha_retiro;
    }

    public function setFechaRetiro(\DateTimeInterface $fecha_retiro): self
    {
        $this->fecha_retiro = $fecha_retiro;

        return $this;
    }


}
