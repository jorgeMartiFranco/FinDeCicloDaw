<?php
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="historico_equipos_competiciones")
 */
class HistoricoEquipoCompeticion {
    /**
     * @ORM\Id @ORM\Column(type="integer", name="Id_Equipo_Competicion") @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\Column(type="string", name="Puesto_Final")
     */
    private $puestoFinal;

    /**
     * @ORM\Column(type="integer", name="Ganados")
     */
    private $ganados;

    /**
     * @ORM\Column(type="integer", name="Empatados")
     */
    private $empatados;

    /**
     * @ORM\Column(type="integer", name="Perdidos")
     */
    private $perdidos;

    /**
     * @ORM\ManyToOne(targetEntity="Competicion")
     * @ORM\JoinColumn(name="Competicion",referencedColumnName="Id_Competicion")
     */
    private $competicion;
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
    
    function __construct($competicion, $temporada, $equipo) {
        $this->competicion = $competicion;
        $this->temporada = $temporada;
        $this->equipo = $equipo;
    }
    
    function getId() {
        return $this->id;
    }

    function getPuestoFinal() {
        return $this->puestoFinal;
    }

    function getCompeticion() {
        return $this->competicion;
    }

    function getTemporada() {
        return $this->temporada;
    }

    function getGanados() {
        return $this->ganados;
    }

    function getEmpatados() {
        return $this->empatados;
    }
    function getPerdidos() {
        return $this->perdidos;
    }

    function getEquipo() {
        return $this->equipo;
    }

    function setPuestoFinal($puestoFinal) {
        $this->puestoFinal = $puestoFinal;
    }

    function setCompeticion($competicion) {
        $this->competicion = $competicion;
    }

    function setTemporada($temporada) {
        $this->temporada = $temporada;
    }

    function setEquipo($equipo) {
        $this->equipo = $equipo;
    }

    function setGanados($ganados) {
        $this->ganados = $ganados;
    }
    function setEmpatados($empatados) {
        $this->empatados = $empatados;
    }
    function setPerdidos($perdidos) {
        $this->perdidos = $perdidos;
    }




    
}


?>