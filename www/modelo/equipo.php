<?php
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="equipos")
 */
class Equipo {
    
    /**
     * @ORM\Id @ORM\Column(type="integer", name="Id_Equipo") @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\Column(type="string", name="Genero")
     */
    private $genero;

    /**
     * @ORM\ManyToOne(targetEntity="Club")
     * @ORM\JoinColumn(name="Club",referencedColumnName="Id_Club")
     */
    private $club;
    /**
     * @ORM\ManyToOne(targetEntity="TipoEquipo")
     * @ORM\JoinColumn(name="Tipo_Equipo",referencedColumnName="Id_Tipo_Equipo")
     */
    private $tipoEquipo;
    /**
     * @ORM\ManyToOne(targetEntity="Competicion")
     * @ORM\JoinColumn(name="Competicion",referencedColumnName="Id_Competicion")
     */
    private $competicion;
    
    function __construct($club, $tipoEquipo, $competicion) {
        $this->club = $club;
        $this->tipoEquipo = $tipoEquipo;
        $this->competicion = $competicion;
    }

    
    function getId() {
        return $this->id;
    }

    function getClub() {
        return $this->club;
    }

    function getTipoEquipo() {
        return $this->tipoEquipo;
    }

    function getCompeticion() {
        return $this->competicion;
    }

    function setClub($club) {
        $this->club = $club;
    }

    function setTipoEquipo($tipoEquipo) {
        $this->tipoEquipo = $tipoEquipo;
    }

    function setCompeticion($competicion) {
        $this->competicion = $competicion;
    }


}


?>
