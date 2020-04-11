<?php
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="tipos_equipo")
 */
class TipoEquipo {
    /**
     * @ORM\Id @ORM\Column(type="integer", name="Id_Tipo_Equipo") @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\Column(type="string", name="Tipo")
     */
    private $tipo;
    
    function __construct($tipo) {
        $this->tipo = $tipo;
    }

    
    function getId() {
        return $this->id;
    }

    function getTipo() {
        return $this->tipo;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }


}

?>