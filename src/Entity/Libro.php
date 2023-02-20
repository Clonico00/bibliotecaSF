<?php

namespace App\Entity;

use App\Repository\LibroRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


#[ORM\Entity(repositoryClass: LibroRepository::class)]
#[ORM\Table(name: 'libro', uniqueConstraints: [new ORM\UniqueConstraint(name: 'titulo_autor_idx', columns: ['titulo', 'autor'])])]
#[UniqueEntity(fields: ['titulo', 'autor'])]
class Libro
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titulo = null;

    #[ORM\Column(length: 255)]
    private ?string $autor = null;

    #[ORM\Column(length: 255)]
    private ?string $editorial = null;

    #[ORM\Column(length: 255)]
    private ?string $genero = null;

    #[ORM\Column]
    private ?int $numero_ejemplares = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getAutor(): ?string
    {
        return $this->autor;
    }

    public function setAutor(string $autor): self
    {
        $this->autor = $autor;

        return $this;
    }

    public function getEditorial(): ?string
    {
        return $this->editorial;
    }

    public function setEditorial(string $editorial): self
    {
        $this->editorial = $editorial;

        return $this;
    }

    public function getGenero(): ?string
    {
        return $this->genero;
    }

    public function setGenero(string $genero): self
    {
        $this->genero = $genero;

        return $this;
    }

    public function getNumeroEjemplares(): ?int
    {
        return $this->numero_ejemplares;
    }

    public function setNumeroEjemplares(int $numero_ejemplares): self
    {
        $this->numero_ejemplares = $numero_ejemplares;

        return $this;
    }

    public function __toString() {
        return $this->getTitulo();
    }

    public function getEjemplares() {
        /*buscamos todos los ejemplares que tengan este libro*/


    }

}
