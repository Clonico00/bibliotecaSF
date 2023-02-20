<?php

namespace App\Entity;

use App\Repository\EjemplarRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EjemplarRepository::class)]
class Ejemplar
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Libro $libro = null;

    #[ORM\Column(length: 255)]
    private ?string $estado = null;

    #[ORM\Column(length: 255)]
    private ?string $estanteria = null;

    #[ORM\Column(length: 255)]
    private ?string $edicion = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibro(): ?Libro
    {
        return $this->libro;
    }

    public function setLibro(?Libro $libro): self
    {
        $this->libro = $libro;

        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    public function getEstanteria(): ?string
    {
        return $this->estanteria;
    }

    public function setEstanteria(string $estanteria): self
    {
        $this->estanteria = $estanteria;

        return $this;
    }

    public function getEdicion(): ?string
    {
        return $this->edicion;
    }

    public function setEdicion(string $edicion): self
    {
        $this->edicion = $edicion;

        return $this;
    }

    public function __toString()
    {
        return $this->getLibro()->getTitulo();
    }


}
