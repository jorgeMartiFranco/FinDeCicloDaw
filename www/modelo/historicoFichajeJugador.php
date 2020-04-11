<?php
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="historico_fichajes_jugadores")
 */
class HistoricoFichajeJugador {
    /**
     * @ORM\Id @ORM\Column(type="integer", name="Id_Fichaje_Jugador") @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\Column(type="date", name="Fecha_Inicio")
     */
    private $fechaInicio;
    /**
     * @ORM\Column(type="date", name="Fecha_Fin")
     */
    private $fechaFin;
    /**
     * @ORM\ManyToOne(targetEntity="Jugador")
     * @ORM\JoinColumn(name="Jugador",referencedColumnName="Id_Jugador")
     */
    private $jugador;
    /**
     * @ORM\ManyToOne(targetEntity="Equipo")
     * @ORM\JoinColumn(name="Equipo_Emisor",referencedColumnName="Id_Equipo")
     */
    private $equipoEmisor;
    /**
     * @ORM\ManyToOne(targetEntity="Equipo")
     * @ORM\JoinColumn(name="Equipo_Receptor",referencedColumnName="Id_Equipo")
     */
    private $equipoReceptor;
    
    function __construct($fechaInicio, $jugador, $equipoEmisor, $equipoReceptor) {
        $this->fechaInicio = $fechaInicio;
        $this->jugador = $jugador;
        $this->equipoEmisor = $equipoEmisor;
        $this->equipoReceptor = $equipoReceptor;
    }
    
    function getId() {
        return $this->id;
    }

    function getFechaInicio() {
        return $this->fechaInicio;
    }

    function getFechaFin() {
        return $this->fechaFin;
    }

    function getJugador() {
        return $this->jugador;
    }

    function getEquipoEmisor() {
        return $this->equipoEmisor;
    }

    function getEquipoReceptor() {
        return $this->equipoReceptor;
    }

    function setFechaInicio($fechaInicio) {
        $this->fechaInicio = $fechaInicio;
    }

    function setFechaFin($fechaFin) {
        $this->fechaFin = $fechaFin;
    }

    function setJugador($jugador) {
        $this->jugador = $jugador;
    }

    function setEquipoEmisor($equipoEmisor) {
        $this->equipoEmisor = $equipoEmisor;
    }

    function setEquipoReceptor($equipoReceptor) {
        $this->equipoReceptor = $equipoReceptor;
    }



}

?>
