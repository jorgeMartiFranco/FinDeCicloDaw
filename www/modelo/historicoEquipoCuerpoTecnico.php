<?php
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="historico_equipos_cuerpo_tecnico")
 */
class HistoricoEquipoCuerpoTecnico {
    /**
     * @ORM\Id @ORM\Column(type="integer", name="Id_Equipo_Cuerpo_Tecnico") @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="Equipo")
     * @ORM\JoinColumn(name="Equipo",referencedColumnName="Id_Equipo")
     */
    private $equipo;
    /**
     * @ORM\ManyToOne(targetEntity="Temporada")
     * @ORM\JoinColumn(name="Temporada",referencedColumnName="Id_Temporada")
     */
    private $temporada;
    /**
     * @ORM\ManyToOne(targetEntity="CuerpoTecnico")
     * @ORM\JoinColumn(name="Cuerpo_Tecnico",referencedColumnName="Id_Cuerpo_Tecnico")
     */
    private $cuerpoTecnico;
    
    function __construct($equipo, $tenporada, $cuerpoTecnico) {
        $this->equipo = $equipo;
        $this->tenporada = $tenporada;
        $this->cuerpoTecnico = $cuerpoTecnico;
    }

    
    function getId() {
        return $this->id;
    }

    function getEquipo() {
        return $this->equipo;
    }

    function getTenporada() {
        return $this->tenporada;
    }

    function getCuerpoTecnico() {
        return $this->cuerpoTecnico;
    }

    function setEquipo($equipo) {
        $this->equipo = $equipo;
    }

    function setTenporada($tenporada) {
        $this->tenporada = $tenporada;
    }

    function setCuerpoTecnico($cuerpoTecnico) {
        $this->cuerpoTecnico = $cuerpoTecnico;
    }


}

?>