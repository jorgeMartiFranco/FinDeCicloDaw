<?php
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="continentes")
 */
class Continente {
    /**
     * @ORM\Id @ORM\Column(type="integer", name="Id_Continente") @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\Column(type="string", name="Nombre")
     */
    private $nombre;
    
    function __construct($nombre) {
        $this->nombre = $nombre;
    }

    
    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }


}

?>