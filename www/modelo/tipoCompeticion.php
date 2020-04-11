<?php
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="tipos_competicion")
 */
class TipoCompeticion {
    /**
     * @ORM\Id @ORM\Column(type="integer", name="Id_Tipo_Competicion") @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\Column(type="string", name="Tipo_Competicion")
     */
    private $tipoCompeticion;
    /**
     * @ORM\Column(type="string", name="Descripcion")
     */
    private $descripcion;
    
    function __construct($tipoCompeticion) {
        $this->tipoCompeticion = $tipoCompeticion;
    }

    function getId() {
        return $this->id;
    }

    function getTipoCompeticion() {
        return $this->tipoCompeticion;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function setTipoCompeticion($tipoCompeticion) {
        $this->tipoCompeticion = $tipoCompeticion;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }


}

?>