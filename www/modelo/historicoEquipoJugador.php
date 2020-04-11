<?php
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="historico_equipos_jugadores")
 */
class HistoricoEquipoJugador {
    /**
     * @ORM\Id @ORM\Column(type="integer", name="Id_Equipo_Jugador") @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="Jugador")
     * @ORM\JoinColumn(name="Jugador",referencedColumnName="Id_Jugador")
     */
    private $jugador;
    /**
     * @ORM\ManyToOne(targetEntity="Temporada")
     * @ORM\JoinColumn(name="Temporada",referencedColumnName="Id_Temporada")
     */
    private $temporada;
    /**
     * @ORM\ManyToOne(targetEntity="Equipo")
     * @ORM\JoinColumn(name="Equipo",referencedColumnName="Id_Equipo")
     */
    private $equipo;
    
    
    function __construct($jugador, $temporada, $equipo) {
        $this->jugador = $jugador;
        $this->temporada = $temporada;
        $this->equipo = $equipo;
    }

    
    function getId() {
        return $this->id;
    }

    function getJugador() {
        return $this->jugador;
    }

    function getTemporada() {
        return $this->temporada;
    }

    function getEquipo() {
        return $this->equipo;
    }

    function setJugador($jugador) {
        $this->jugador = $jugador;
    }

    function setTemporada($temporada) {
        $this->temporada = $temporada;
    }

    function setEquipo($equipo) {
        $this->equipo = $equipo;
    }


}
?>