<?php
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="cuerpo_tecnico")
 */
class CuerpoTecnico {
    /**
     * @ORM\Id @ORM\Column(type="integer", name="Id_Cuerpo_Tecnico") @ORM\GeneratedValue
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
     * @ORM\Column(type="string", name="Reputacion")
     */
    private $reputacion;
    /**
     * @ORM\Column(type="date", name="Fecha_Nacimiento")
     */
    private $fechaNacimiento;

    /**
     * @ORM\Column(type="string", name="Genero")
     */
    private $genero;

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
     * @ORM\ManyToOne(targetEntity="Pais")
     * @ORM\JoinColumn(name="Pais",referencedColumnName="Id_Pais")
     */
    private $pais;
    /**
     * @ORM\ManyToOne(targetEntity="PuestoCuerpoTecnico")
     * @ORM\JoinColumn(name="Puesto",referencedColumnName="Id_Puesto_Cuerpo_Tecnico")
     */
    private $puesto;
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
    
    
    function __construct($nombre, $apellido1, $fechaNacimiento, $pais, $puesto, $tipoContrato, $equipoActual) {
        $this->nombre = $nombre;
        $this->apellido1 = $apellido1;
        $this->fechaNacimiento = $fechaNacimiento;
        $this->pais = $pais;
        $this->puesto = $puesto;
        $this->tipoContrato = $tipoContrato;
        $this->equipoActual = $equipoActual;
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

    function getReputacion() {
        return $this->reputacion;
    }

    function getFechaNacimiento() {
        return $this->fechaNacimiento;
    }

    function getPais() {
        return $this->pais;
    }

    function getPuesto() {
        return $this->puesto;
    }

    function getGenero() {
        return $this->genero;
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

    function setGenero($genero) {
        $this->genero = $genero;
    }

    function setFechaNacimiento($fechaNacimiento) {
        $this->fechaNacimiento = $fechaNacimiento;
    }

    function setPais($pais) {
        $this->pais = $pais;
    }

    function setPuesto($puesto) {
        $this->puesto = $puesto;
    }

    function setTipoContrato($tipoContrato) {
        $this->tipoContrato = $tipoContrato;
    }

    function setEquipoActual($equipoActual) {
        $this->equipoActual = $equipoActual;
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

    function setTwitter($twitter) {
        $this->twitter = $twitter;
    }

    function setFacebook($facebook) {
        $this->facebook = $facebook;
    }

    function setInstagram($instagram) {
        $this->instagram = $instagram;
    }

    function setReputacion($reputacion) {
        $this->reputacion = $reputacion;
    }




}

?>