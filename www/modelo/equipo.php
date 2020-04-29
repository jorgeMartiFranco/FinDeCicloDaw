<?php
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="equipos")
 */
class Equipo {
    
    /**
     * @ORM\Id @ORM\Column(type="integer", name="Id_Equipo") @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\Column(type="string", name="Genero")
     */
    private $genero;
    /**
     * @ORM\Column(type="integer", name="Reputacion")
     */
    private $reputacion;

    /**
     * @ORM\Column(type="integer", name="Fecha_Sin_Entrenador")
     */
    private $fechaSinEntrenador;

    /**
     * @ORM\ManyToOne(targetEntity="Club")
     * @ORM\JoinColumn(name="Club",referencedColumnName="Id_Club")
     */
    private $club;
    /**
     * @ORM\ManyToOne(targetEntity="TipoEquipo")
     * @ORM\JoinColumn(name="Tipo_Equipo",referencedColumnName="Id_Tipo_Equipo")
     */
    private $tipoEquipo;
    /**
     * @ORM\ManyToOne(targetEntity="Competicion")
     * @ORM\JoinColumn(name="Competicion",referencedColumnName="Id_Competicion")
     */
    private $competicion;

    /** @ORM\OneToMany(targetEntity="CuerpoTecnico", mappedBy="equipoActual")
     */
    private $cuerpoTecnico;

     /** @ORM\OneToMany(targetEntity="Jugador", mappedBy="equipoActual")
     */
    private $jugadores;


    /**
    * @ORM\ManyToMany(targetEntity="Usuario", mappedBy="equiposFavoritos")
    */
    private $usuarios;
    
    function __construct($club, $tipoEquipo, $competicion,$reputacion) {
        $this->club = $club;
        $this->tipoEquipo = $tipoEquipo;
        $this->competicion = $competicion;
        $this->reputacion=$reputacion;
        $this->cuerpoTecnico=new Doctrine\Common\Collections\ArrayCollection();
        $this->jugadores=new Doctrine\Common\Collections\ArrayCollection();
        $this->usuarios=new Doctrine\Common\Collections\ArrayCollection();
    }

    
    function getId() {
        return $this->id;
    }

    function getClub() {
        return $this->club;
    }

    function getTipoEquipo() {
        return $this->tipoEquipo;
    }

    function getReputacion() {
        return $this->reputacion;
    }

    function getCompeticion() {
        return $this->competicion;
    }

    function getFechaSinEntrenador() {
        return $this->fechaSinEntrenador;
    }

    function getJugadores() {
        return $this->jugadores;
    }

    function getGenero() {
        return $this->genero;
    }

    function getCuerpoTecnico() {
        return $this->cuerpoTecnico;
    }

    function setClub($club) {
        $this->club = $club;
    }

    function setTipoEquipo($tipoEquipo) {
        $this->tipoEquipo = $tipoEquipo;
    }

    function setCompeticion($competicion) {
        $this->competicion = $competicion;
    }

    function setFechaSinEntrenador($fechaSinEntrenador) {
        $this->fechaSinEntrenador = $fechaSinEntrenador;
    }


    function setReputacion($reputacion) {
        $this->reputacion = $reputacion;
    }

    function setCuerpoTecnico($cuerpoTecnico) {
        $this->cuerpoTecnico = $cuerpoTecnico;
    }

    function setJugadores($jugadores) {
        $this->jugadores = $jugadores;
    }

    function setGenero($genero) {
        $this->genero = $genero;
    }
    
    function getUsuarios() {
        return $this->usuarios;
    }

    function setUsuarios($usuarios) {
        $this->usuarios = $usuarios;
    }


}


?>
