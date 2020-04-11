<?php
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="historico_fichajes_cuerpo_tecnico")
 */
class HistoricoFichajeCuerpoTecnico {
    /**
     * @ORM\Id @ORM\Column(type="integer", name="Id_Fichaje_Cuerpo_Tecnico") @ORM\GeneratedValue
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
     * @ORM\ManyToOne(targetEntity="CuerpoTecnico")
     * @ORM\JoinColumn(name="Cuerpo_Tecnico",referencedColumnName="Id_Cuerpo_Tecnico")
     */
    private $cuerpoTecnico;
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
    
    function __construct($fechaInicio, $cuerpoTecnico, $equipoEmisor, $equipoReceptor) {
        $this->fechaInicio = $fechaInicio;
        $this->cuerpoTecnico = $cuerpoTecnico;
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

    function getCuerpoTecnico() {
        return $this->cuerpoTecnico;
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

    function setCuerpoTecnico($cuerpoTecnico) {
        $this->cuerpoTecnico = $cuerpoTecnico;
    }

    function setEquipoEmisor($equipoEmisor) {
        $this->equipoEmisor = $equipoEmisor;
    }

    function setEquipoReceptor($equipoReceptor) {
        $this->equipoReceptor = $equipoReceptor;
    }


}
?>