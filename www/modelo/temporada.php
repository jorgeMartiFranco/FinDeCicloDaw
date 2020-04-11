<?php
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="temporadas")
 */
class Temporada {
    /**
     * @ORM\Id @ORM\Column(type="integer", name="Id_Temporada") @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\Column(type="string", name="Temporada")
     */
    private $temporada;
    
    function __construct($temporada) {
        $this->temporada = $temporada;
    }

    
    function getId() {
        return $this->id;
    }

    function getTemporada() {
        return $this->temporada;
    }

    function setTemporada($temporada) {
        $this->temporada = $temporada;
    }


}

?>