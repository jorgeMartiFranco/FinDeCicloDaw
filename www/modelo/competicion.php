<?php
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="competiciones")
 */
class Competicion {
    
    /**
     * @ORM\Id @ORM\Column(type="integer", name="Id_Competicion") @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\Column(type="string", name="Nombre")
     */
    private $nombre;
    /**
     * @ORM\Column(type="integer", name="Nivel")
     */
    private $nivel;
    /**
     * @ORM\ManyToOne(targetEntity="Pais")
     * @ORM\JoinColumn(name="Pais",referencedColumnName="Id_Pais")
     */
    private $pais;
    /**
     * @ORM\ManyToOne(targetEntity="Continente")
     * @ORM\JoinColumn(name="Continente",referencedColumnName="Id_Continente")
     */
    private $continente;
    /**
     * @ORM\ManyToOne(targetEntity="TipoCompeticion")
     * @ORM\JoinColumn(name="Tipo_Competicion",referencedColumnName="Id_Tipo_Competicion")
     */
    private $tipoCompeticion;
    
    function __construct($nombre, $nivel, $continente, $tipoCompeticion) {
        $this->nombre = $nombre;
        $this->nivel = $nivel;
        $this->continente = $continente;
        $this->tipoCompeticion = $tipoCompeticion;
    }
    
    
    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getNivel() {
        return $this->nivel;
    }

    function getPais() {
        return $this->pais;
    }

    function getContinente() {
        return $this->continente;
    }

    function getTipoCompeticion() {
        return $this->tipoCompeticion;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setNivel($nivel) {
        $this->nivel = $nivel;
    }

    function setPais($pais) {
        $this->pais = $pais;
    }

    function setContinente($continente) {
        $this->continente = $continente;
    }

    function setTipoCompeticion($tipoCompeticion) {
        $this->tipoCompeticion = $tipoCompeticion;
    }



}

?>