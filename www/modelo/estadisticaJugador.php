<?php
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="estadisticas_jugadores")
 */
class EstadisticaJugador {
    /**
     * @ORM\Id @ORM\Column(type="integer", name="Id_Estadistica_Jugador") @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\Column(type="integer", name="Goles")
     */
    private $goles;
    /**
     * @ORM\Column(type="integer", name="Perdidas")
     */
    private $perdidas;
    /**
     * @ORM\Column(type="integer", name="Recuperaciones")
     */
    private $recuperaciones;
    /**
     * @ORM\ManyToOne(targetEntity="Temporada")
     * @ORM\JoinColumn(name="Temporada",referencedColumnName="Id_Temporada")
     */
    private $temporada;
    /**
     * @ORM\ManyToOne(targetEntity="Jugador")
     * @ORM\JoinColumn(name="Jugador",referencedColumnName="Id_Jugador")
     */
    private $jugador;
    /**
     * @ORM\ManyToOne(targetEntity="Competicion")
     * @ORM\JoinColumn(name="Competicion",referencedColumnName="Id_Competicion")
     */
    private $competicion;

    /**
     * @ORM\ManyToOne(targetEntity="Equipo")
     * @ORM\JoinColumn(name="Equipo",referencedColumnName="Id_Equipo")
     */
    private $equipo;
    
    
    function __construct($goles, $perdidas, $recuperaciones, $temporada, $jugador, $competicion) {
        $this->goles = $goles;
        $this->perdidas = $perdidas;
        $this->recuperaciones = $recuperaciones;
        $this->temporada = $temporada;
        $this->jugador = $jugador;
        $this->competicion = $competicion;
    }
    
    
    function getId() {
        return $this->id;
    }

    function getGoles() {
        return $this->goles;
    }

    function getPerdidas() {
        return $this->perdidas;
    }

    function getRecuperaciones() {
        return $this->recuperaciones;
    }

    function getTemporada() {
        return $this->temporada;
    }

    function getJugador() {
        return $this->jugador;
    }

    function getCompeticion() {
        return $this->competicion;
    }

    function getEquipo() {
        return $this->equipo;
    }

    function setGoles($goles) {
        $this->goles = $goles;
    }

    function setPerdidas($perdidas) {
        $this->perdidas = $perdidas;
    }

    function setRecuperaciones($recuperaciones) {
        $this->recuperaciones = $recuperaciones;
    }

    function setTemporada($temporada) {
        $this->temporada = $temporada;
    }

    function setJugador($jugador) {
        $this->jugador = $jugador;
    }

    function setCompeticion($competicion) {
        $this->competicion = $competicion;
    }

    function setEquipo($equipo) {
        $this->equipo = $equipo;
    }



}

?>