<?php
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="jugadores")
 */
class Jugador {
    /**
     * @ORM\Id @ORM\Column(type="integer", name="Id_Jugador") @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\Column(type="string", name="Nombre")
     */
    private $nombre;
    /**
     * @ORM\Column(type="string", name="Apellido1")
     */
    private $apellido1;
    /**
     * @ORM\Column(type="string", name="Apellido2")
     */
    private $apellido2;
    /**
     * @ORM\Column(type="string", name="Apodo")
     */
    private $apodo;
    /**
     * @ORM\Column(type="date", name="Fecha_Nacimiento")
     */
    private $fechaNacimiento;
    /**
     * @ORM\Column(type="string", name="Genero")
     */
    private $genero;

    /**
     * @ORM\Column(type="integer", name="Reputacion")
     */
    private $reputacion;
    

    /**
     * @ORM\Column(type="datetime", name="Ultimo_Cambio_Equipo")
     */
    private $ultimoCambioEquipo;
    /**
     * @ORM\Column(type="string", name="Twitter")
     */
    private $twitter;
    /**
     * @ORM\Column(type="string", name="Facebook")
     */
    private $facebook;
    /**
     * @ORM\Column(type="string", name="Instagram")
     */
    private $instagram;
    /**
     * @ORM\Column(type="date", name="Inicio_Contrato")
     */
    private $inicioContrato;
    /**
     * @ORM\Column(type="date", name="Fin_Contrato")
     */
    private $finContrato;
    /**
     * @ORM\ManyToOne(targetEntity="Pais")
     * @ORM\JoinColumn(name="Pais",referencedColumnName="Id_Pais")
     */
    private $pais;
    /**
     * @ORM\ManyToOne(targetEntity="TipoContrato")
     * @ORM\JoinColumn(name="Tipo_Contrato",referencedColumnName="Id_Tipo_Contrato")
     */
    private $tipoContrato;
    /**
     * @ORM\ManyToOne(targetEntity="Equipo")
     * @ORM\JoinColumn(name="Equipo_Actual",referencedColumnName="Id_Equipo")
     */
    private $equipoActual;
    
    /**
     * @ORM\ManyToMany(targetEntity="Puesto", inversedBy="jugadores")
     * @ORM\JoinTable(name="jugadores_puestos", joinColumns={@ORM\JoinColumn(name="Jugador", referencedColumnName="Id_Jugador")},
     * inverseJoinColumns={@ORM\JoinColumn(name="Puesto", referencedColumnName="Id_Puesto_Jugador")})
     */
    private $puestos; //array N:M
    
    function __construct($nombre, $apellido1, $fechaNacimiento, $pais, $tipoContrato,$reputacion) {
        $this->nombre = $nombre;
        $this->apellido1 = $apellido1;
        $this->fechaNacimiento = $fechaNacimiento;
        $this->pais = $pais;
        $this->tipoContrato = $tipoContrato;
        $this->reputacion=$reputacion;
        $this->puestos=new Doctrine\Common\Collections\ArrayCollection();
    }

    
    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getApellido1() {
        return $this->apellido1;
    }
    function getApellido2() {
        return $this->apellido2;
    }

    function getApodo() {
        return $this->apodo;
    }

    function getFechaNacimiento() {
        return $this->fechaNacimiento;
    }

    function getInicioContrato() {
        return $this->inicioContrato;
    }

    function getFinContrato() {
        return $this->finContrato;
    }

    function getPais() {
        return $this->pais;
    }

    function getReputacion() {
        return $this->reputacion;
    }

    function getTipoContrato() {
        return $this->tipoContrato;
    }

    function getEquipoActual() {
        return $this->equipoActual;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setApellido1($apellido1) {
        $this->apellido1 = $apellido1;
    }
    function setApellido2($apellido2) {
        $this->apellido2 = $apellido2;
    }

    function setApodo($apodo) {
        $this->apodo = $apodo;
    }

    function setFechaNacimiento($fechaNacimiento) {
        $this->fechaNacimiento = $fechaNacimiento;
    }

    function setInicioContrato($inicioContrato) {
        $this->inicioContrato = $inicioContrato;
    }

    function setFinContrato($finContrato) {
        $this->finContrato = $finContrato;
    }

    function setPais($pais) {
        $this->pais = $pais;
    }

    function setTipoContrato($tipoContrato) {
        $this->tipoContrato = $tipoContrato;
    }

    function setEquipoActual($equipoActual) {
        $this->equipoActual = $equipoActual;
    }

    function getPuestos() {
        return $this->puestos;
    }

    function setPuestos($puestos) {
        $this->puestos = $puestos;
    }

    function setTwitter($twitter) {
        $this->twitter = $twitter;
    }

    function setFacebook($facebook) {
        $this->facebook = $facebook;
    }

    function setInstagram($instagram) {
        $this->instagram = $instagram;
    }

    function getTwitter() {
        return $this->twitter;
    }

    function getFacebook() {
        return $this->facebook;
    }

    function getInstagram() {
        return $this->instagram;
    }

    function setReputacion($reputacion) {
        $this->reputacion = $reputacion;
    }


}

?>