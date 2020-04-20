<?php
use Doctrine\ORM\Mapping as ORM;

/**
    * @ORM\Entity
    * @ORM\Table(name="clubs")
    */
class Club {
    
    /**
     * @ORM\Id @ORM\Column(type="integer", name="Id_Club") @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\Column(type="string", name="Nombre_Completo")
     */
    private $nombreCompleto;
    /**
     * @ORM\Column(type="string", name="Nombre_Corto")
     */
    private $nombreCorto;
    /**
     * @ORM\Column(type="string", name="Fundacion")
     */
    private $fundacion;
    

    /**
     * @ORM\ManyToOne(targetEntity="Pais")
     * @ORM\JoinColumn(name="Pais",referencedColumnName="Id_Pais")
     */
    private $pais;
    
    function __construct($nombreCompleto, $nombreCorto, $pais) {
        $this->nombreCompleto = $nombreCompleto;
        $this->nombreCorto = $nombreCorto;
        $this->pais = $pais;
    }
    
    function getId() {
        return $this->id;
    }

    function getNombreCompleto() {
        return $this->nombreCompleto;
    }

    function getNombreCorto() {
        return $this->nombreCorto;
    }

    function getFundacion() {
        return $this->fundacion;
    }

    function getPais() {
        return $this->pais;
    }

    function setNombreCompleto($nombreCompleto) {
        $this->nombreCompleto = $nombreCompleto;
    }

    function setNombreCorto($nombreCorto) {
        $this->nombreCorto = $nombreCorto;
    }

    function setPais($pais) {
        $this->pais = $pais;
    }

    function setFundacion($fundacion) {
        $this->fundacion = $fundacion;
    }



}


?>