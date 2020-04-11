<?php
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="tipos_contrato")
 */
class TipoContrato {
    /**
     * @ORM\Id @ORM\Column(type="integer", name="Id_Tipo_Contrato") @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\Column(type="string", name="Tipo_Contrato")
     */
    private $tipoContrato;
    /**
     * @ORM\Column(type="string", name="Descripcion")
     */
    private $descripcion;
    
    function __construct($tipoContrato) {
        $this->tipoContrato = $tipoContrato;
    }

    
    function getId() {
        return $this->id;
    }

    function getTipoContrato() {
        return $this->tipoContrato;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function setTipoContrato($tipoContrato) {
        $this->tipoContrato = $tipoContrato;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }


}

?>