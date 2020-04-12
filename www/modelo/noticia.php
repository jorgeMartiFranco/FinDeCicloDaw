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
     * @ORM\Column(type="string", name="DescripcionImagen")
     */
    private $descripcionImagen;
    /**
     * @ORM\Column(type="date", name="Fecha")
     */
    private $fecha;

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

    function getDescripcionImagen() {
        return $this->descripcionImagen;
    }

    function getFecha() {
        return $this->fecha;
    }

   

    function getCompeticion() {
        return $this->competicion;
    }

    function setTitular($titular) {
        $this->titular = $titular;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setNoticia($noticia) {
        $this->noticia = $noticia;
    }
    function setDescripcionImagen($descripcionImagen) {
        $this->descripcionImagen = $descripcionImagen;
    }

    

    function setCompeticion($competicion) {
        $this->competicion = $competicion;
    }



    


    
}