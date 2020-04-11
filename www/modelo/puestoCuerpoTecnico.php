<?php
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="puestos_cuerpo_tecnico")
 */
class PuestoCuerpoTecnico {
    /**
     * @ORM\Id @ORM\Column(type="integer", name="Id_Puesto_Cuerpo_Tecnico") @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\Column(type="string", name="Puesto")
     */
    private $puesto;
    /**
     * @ORM\Column(type="string", name="Descripcion")
     */
    private $descripcion;
    
    function __construct($puesto) {
        $this->puesto = $puesto;
    }

    
    function getId() {
        return $this->id;
    }

    function getPuesto() {
        return $this->puesto;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function setPuesto($puesto) {
        $this->puesto = $puesto;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }


}
?>
