<?php
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="noticias")
 */
class Noticia {

    /**
     * @ORM\Id @ORM\Column(type="integer", name="Id_Noticia") @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\Column(type="string", name="Titular")
     */
    private $titular;
    /**
     * @ORM\Column(type="string", name="Noticia")
     */
    private $noticia;

    /**
     * @ORM\ManyToOne(targetEntity="Competicion")
     * @ORM\JoinColumn(name="Competicion",referencedColumnName="Id_Competicion")
     */
    private $competicion;
    
    
    function __construct($titular, $noticia, $seccion) {
        $this->titular = $titular;
        $this->noticia = $noticia;
        $this->seccion = $seccion;
    }
    
    
    function getId() {
        return $this->id;
    }

    function getTitular() {
        return $this->titular;
    }

    function getNoticia() {
        return $this->noticia;
    }

    function getSeccion() {
        return $this->seccion;
    }

    function getCompeticion() {
        return $this->competicion;
    }

    function setTitular($titular) {
        $this->titular = $titular;
    }

    function setNoticia($noticia) {
        $this->noticia = $noticia;
    }

    function setSeccion($seccion) {
        $this->seccion = $seccion;
    }

    function setCompeticion($competicion) {
        $this->competicion = $competicion;
    }



    


    
}