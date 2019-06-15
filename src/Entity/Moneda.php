<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MonedaRepository")
 */
class Moneda
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $compra;

    /**
     * @ORM\Column(type="float")
     */
    private $venta;

    /**
     * @ORM\Column(type="float")
     */
    private $montoRecibido;

    /**
     * @ORM\Column(type="float")
     */
    private $montoEntregado;

    /**
     * @ORM\Column(type="string", length=7)
     */
    private $tipoCambio;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompra(): ?float
    {
        return $this->compra;
    }

    public function setCompra(float $compra): self
    {
        $this->compra = $compra;

        return $this;
    }

    public function getVenta(): ?float
    {
        return $this->venta;
    }

    public function setVenta(float $venta): self
    {
        $this->venta = $venta;

        return $this;
    }

    public function getMontoRecibido(): ?float
    {
        return $this->montoRecibido;
    }

    public function setMontoRecibido(float $montoRecibido): self
    {
        $this->montoRecibido = $montoRecibido;

        return $this;
    }

    public function getMontoEntregado(): ?float
    {
        return $this->montoEntregado;
    }

    public function setMontoEntregado(float $montoEntregado): self
    {
        $this->montoEntregado = $montoEntregado;

        return $this;
    }

    public function getTipoCambio(): ?string
    {
        return $this->tipoCambio;
    }

    public function setTipoCambio(string $tipoCambio): self
    {
        $this->tipoCambio = $tipoCambio;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }
}
