<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Cliente
 *
 * @ORM\Table(name="cliente")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ClienteRepository")
 */
class Cliente
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, unique=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="correo", type="string", length=255, unique=true)
     */
    private $correo;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=255, nullable=true)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="celular", type="string", length=255)
     */
    private $celular;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255, nullable=true)
     */
    private $direccion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecharegistro", type="datetime", nullable=true)
     */
    private $fecharegistro;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="horaregistro", type="time", nullable=true)
     */
    private $horaregistro;

    /**
     * @var string
     *
     * @ORM\Column(name="empresa", type="string", length=255, nullable=true)
     */
    private $empresa;

    /**
     * @var string
     *
     * @ORM\Column(name="razonsocial", type="string", length=255, nullable=true)
     */
    private $razonsocial;

    /**
     * @var string
     *
     * @ORM\Column(name="rfc", type="string", length=50, nullable=true)
     */
    private $rfc;

    /**
     * @var string
     *
     * @ORM\Column(name="direccionfiscal", type="string", length=255, nullable=true)
     */
    private $direccionfiscal;

    /**
     * @var string
     *
     * @ORM\Column(name="correofacturacion", type="string", length=255, nullable=true)
     */
    private $correofacturacion;

    /**
     * @var bool
     *
     * @ORM\Column(name="estatus", type="boolean")
     */
    private $estatus;

    /**
     * One Product has Many Features.
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Barco", mappedBy="cliente")
     */
    private $barcos;

    public function __construct() {
        $this->barcos = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Cliente
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set correo
     *
     * @param string $correo
     *
     * @return Cliente
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;

        return $this;
    }

    /**
     * Get correo
     *
     * @return string
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Cliente
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     *
     * @return Cliente
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set celular
     *
     * @param string $celular
     *
     * @return Cliente
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;

        return $this;
    }

    /**
     * Get celular
     *
     * @return string
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     *
     * @return Cliente
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set fecharegistro
     *
     * @param \DateTime $fecharegistro
     *
     * @return Cliente
     */
    public function setFecharegistro($fecharegistro)
    {
        $this->fecharegistro = $fecharegistro;

        return $this;
    }

    /**
     * Get fecharegistro
     *
     * @return \DateTime
     */
    public function getFecharegistro()
    {
        return $this->fecharegistro;
    }

    /**
     * Set horaregistro
     *
     * @param \DateTime $horaregistro
     *
     * @return Cliente
     */
    public function setHoraregistro($horaregistro)
    {
        $this->horaregistro = $horaregistro;

        return $this;
    }

    /**
     * Get horaregistro
     *
     * @return \DateTime
     */
    public function getHoraregistro()
    {
        return $this->horaregistro;
    }

    /**
     * Set empresa
     *
     * @param string $empresa
     *
     * @return Cliente
     */
    public function setEmpresa($empresa)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return string
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * Set razonsocial
     *
     * @param string $razonsocial
     *
     * @return Cliente
     */
    public function setRazonsocial($razonsocial)
    {
        $this->razonsocial = $razonsocial;

        return $this;
    }

    /**
     * Get razonsocial
     *
     * @return string
     */
    public function getRazonsocial()
    {
        return $this->razonsocial;
    }

    /**
     * Set rfc
     *
     * @param string $rfc
     *
     * @return Cliente
     */
    public function setRfc($rfc)
    {
        $this->rfc = $rfc;

        return $this;
    }

    /**
     * Get rfc
     *
     * @return string
     */
    public function getRfc()
    {
        return $this->rfc;
    }

    /**
     * Set direccionfiscal
     *
     * @param string $direccionfiscal
     *
     * @return Cliente
     */
    public function setDireccionfiscal($direccionfiscal)
    {
        $this->direccionfiscal = $direccionfiscal;

        return $this;
    }

    /**
     * Get direccionfiscal
     *
     * @return string
     */
    public function getDireccionfiscal()
    {
        return $this->direccionfiscal;
    }

    /**
     * Set correofacturacion
     *
     * @param string $correofacturacion
     *
     * @return Cliente
     */
    public function setCorreofacturacion($correofacturacion)
    {
        $this->correofacturacion = $correofacturacion;

        return $this;
    }

    /**
     * Get correofacturacion
     *
     * @return string
     */
    public function getCorreofacturacion()
    {
        return $this->correofacturacion;
    }

    /**
     * Set estatus
     *
     * @param boolean $estatus
     *
     * @return Cliente
     */
    public function setEstatus($estatus)
    {
        $this->estatus = $estatus;

        return $this;
    }

    /**
     * Get estatus
     *
     * @return bool
     */
    public function getEstatus()
    {
        return $this->estatus;
    }

    /**
     * Get barcos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBarcos()
    {
        return $this->barcos;
    }
}

