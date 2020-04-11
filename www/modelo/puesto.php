<?php
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="puestos")
 */
class Puesto {
    /**
     * @ORM\Id @ORM\Column(type="integer", name="Id_Puesto_Jugador") @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\Column(type="string", name="Puesto")
     */
    private $puesto;
    /**
     * @ORM\Column(type="string", name="Puesto_Corto")
     */
    private $puestoCorto;
    /**
     * @ORM\Column(type="string", name="Descripcion")
     */
    private $descripcion;
    /**
    * @ORM\ManyToMany(targetEntity="Jugador", mappedBy="puestos")
    */
    private $jugadores; //array N:M
    
    function __construct($puesto, $puestoCorto) {
        $this->puesto = $puesto;
        $this->puestoCorto = $puestoCorto;
        $this->jugadores=new Doctrine\Common\Collections\ArrayCollection();
    }
    
    function getId() {
        return $this->id;
    }

    function getPuesto() {
        return $this->puesto;
    }

    function getPuestoCorto() {
        return $this->puestoCorto;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function setPuesto($puesto) {
        $this->puesto = $puesto;
    }

    function setPuestoCorto($puestoCorto) {
        $this->puestoCorto = $puestoCorto;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function getJugadores() {
        return $this->jugadores;
    }

    function setJugadores($jugadores) {
        $this->jugadores = $jugadores;
    }



}
?>
