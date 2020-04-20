<?php

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="paises")
 */
class Pais {
    /**
     * @ORM\Id @ORM\Column(type="integer", name="Id_Pais") @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\Column(type="string", name="Codigo")
     */
    private $codigo;
    /**
     * @ORM\Column(type="string", name="Nombre")
     */
    private $nombre;
    /**
     * @ORM\Column(type="string", name="Nacionalidad")
     */
    private $nacionalidad;
    /**
     * @ORM\ManyToOne(targetEntity="Continente")
     * @ORM\JoinColumn(name="Continente",referencedColumnName="Id_Continente")
     */
    private $continente;
    
    function __construct($codigo, $nombre, $continente) {
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->continente = $continente;
    }
    
    function getId() {
        return $this->id;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getNacionalidad() {
        return $this->nacionalidad;
    }

    function getContinente() {
        return $this->continente;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setContinente($continente) {
        $this->continente = $continente;
    }

    function setNacionalidad($nacionalidad) {
        $this->nacionalidad = $nacionalidad;
    }



}
?>