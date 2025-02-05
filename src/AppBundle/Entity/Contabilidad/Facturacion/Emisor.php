<?php

namespace AppBundle\Entity\Contabilidad\Facturacion;

use AppBundle\Entity\Contabilidad\Facturacion;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Emisor
 *
 * @ORM\Table(name="contabilidad_facturacion_emisor")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Contabilidad\Facturacion\EmisorRepository")
 * @Vich\Uploadable
 */
class Emisor
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
     * @Assert\NotBlank(message="Este campo no puede estar vacio")
     *
     * @ORM\Column(name="alias", type="string", length=100)
     */
    private $alias;

    /**
     * @var string
     *
     * @Assert\Regex(
     *     pattern="/^([A-ZÑ\x26]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1]))((-)?([A-Z\d]{3}))?$/",
     *     message="El RFC es invalido"
     *     )
     *
     * @ORM\Column(name="rfc", type="string", length=20)
     */
    private $rfc;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Este campo no puede estar vacio")
     *
     * @ORM\Column(name="regimen_fiscal", type="string", length=10)
     */
    private $regimenFiscal;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Este campo no puede estar vacio")
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Este campo no puede estar vacio")
     *
     * @ORM\Column(name="codigo_postal", type="string", length=10)
     */
    private $codigoPostal;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Este campo no puede estar vacio")
     *
     * @ORM\Column(name="direccion", type="string")
     */
    private $direccion;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Este campo no puede estar vacio")
     *
     * @ORM\Column(name="emails", type="string", nullable=true)
     */
    private $emails;

    /**
     * @var File
     *
     * @Assert\Image(
     *     mimeTypes={"image/*"},
     *     mimeTypesMessage="Solo se permiten imagenes",
     *     maxSize="2M",
     *     maxSizeMessage="El tamaño maximo es 2MB"
     * )
     *
     * @Vich\UploadableField(mapping="facturacion_emisor_logo", fileNameProperty="logo")
     */
    private $logoFile;

    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string")
     */
    private $logo;

    /**
     * @var File
     *
     * @Assert\File()
     *
     * @Vich\UploadableField(mapping="facturacion_emisor_cer", fileNameProperty="cer")
     */
    private $cerFile;

    /**
     * @var string
     *
     * @ORM\Column(name="emisor_cer", type="string")
     */
    private $cer;

    /**
     * @var File
     *
     * @Assert\File()
     *
     * @Vich\UploadableField(mapping="facturacion_emisor_key", fileNameProperty="key")
     */
    private $keyFile;

    /**
     * @var string
     *
     * @ORM\Column(name="emisor_key", type="string")
     */
    private $key;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Este campo no puede estar vacio")
     *
     * @ORM\Column(name="usuario_pac", type="string")
     */
    private $usuarioPAC;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Este campo no puede estar vacio")
     *
     * @ORM\Column(name="password_pac", type="string")
     */
    private $passwordPAC;

    /**
     * @var string
     *
     * @ORM\Column(name="emisor_password", type="string")
     */
    private $password;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_at", type="datetime")
     */
    private $updateAt;

    /**
     * @var int
     *
     * @ORM\Column(name="estatus", type="boolean")
     */
    private $estatus;

    public function __construct()
    {
        $this->estatus = true;
        $this->updateAt = new \DateTime();
    }

    public function __toString()
    {
        return $this->alias . ' - ' . $this->nombre;
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
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param string $alias
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
    }

    /**
     * Set rfc
     *
     * @param string $rfc
     *
     * @return Emisor
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
     * @return string
     */
    public function getRegimenFiscal()
    {
        return $this->regimenFiscal;
    }

    public function getRegimenFiscalValue()
    {
        return array_flip(Facturacion::$regimenesFiscales)[$this->regimenFiscal];
    }

    /**
     * @param string $regimenFiscal
     */
    public function setRegimenFiscal($regimenFiscal)
    {
        $this->regimenFiscal = $regimenFiscal;
    }


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Emisor
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
     * Set codigoPostal
     *
     * @param string $codigoPostal
     *
     * @return Emisor
     */
    public function setCodigoPostal($codigoPostal)
    {
        $this->codigoPostal = $codigoPostal;

        return $this;
    }

    /**
     * Get codigoPostal
     *
     * @return string
     */
    public function getCodigoPostal()
    {
        return $this->codigoPostal;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     *
     * @return Emisor
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
     * Set logo
     *
     * @param string $logo
     *
     * @return Emisor
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param $logo
     */
    public function setLogoFile(File $logo)
    {
        $this->logoFile = $logo;

        if (null !== $logo) {
            $this->updateAt = new \DateTimeImmutable();
        }
    }

    public function getLogoFile()
    {
        return $this->logoFile;
    }

    /**
     * Set cer
     *
     * @param string $cer
     *
     * @return Emisor
     */
    public function setCer($cer)
    {
        $this->cer = $cer;

        return $this;
    }

    /**
     * Get cer
     *
     * @return string
     */
    public function getCer()
    {
        return $this->cer;
    }

    public function setCerFile(File $cer = null)
    {
        $this->cerFile = $cer;

        if ($cer) {
            $this->updateAt = new \DateTimeImmutable();
        }
    }

    public function getCerFile()
    {
        return $this->cerFile;
    }

    /**
     * Set key
     *
     * @param string $key
     *
     * @return Emisor
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    public function setKeyFile(File $key = null)
    {
        $this->keyFile = $key;

        if ($key) {
            $this->updateAt = new \DateTimeImmutable();
        }
    }

    public function getKeyFile()
    {
        return $this->keyFile;
    }

    /**
     * @return string
     */
    public function getUsuarioPAC()
    {
        return $this->usuarioPAC;
    }

    /**
     * @param string $usuarioPAC
     */
    public function setUsuarioPAC($usuarioPAC)
    {
        $this->usuarioPAC = $usuarioPAC;
    }

    /**
     * @return string
     */
    public function getPasswordPAC()
    {
        return $this->passwordPAC;
    }

    /**
     * @param string $passwordPAC
     */
    public function setPasswordPAC($passwordPAC)
    {
        $this->passwordPAC = $passwordPAC;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Emisor
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
     * Set updateAt
     *
     * @param \DateTime $updateAt
     *
     * @return Emisor
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * Get updateAt
     *
     * @return \DateTime
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * @return boolean
     */
    public function getEstatus()
    {
        return $this->estatus;
    }

    /**
     * @param boolean $estatus
     */
    public function setEstatus($estatus)
    {
        $this->estatus = $estatus;
    }

    /**
     * @return string
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * @param array $emails
     */
    public function setEmails($emails)
    {
        $this->emails = $emails;
    }
}
