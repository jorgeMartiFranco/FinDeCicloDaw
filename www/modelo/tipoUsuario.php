<?php
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="tipos_usuario")
 */
class TipoUsuario {
    /**
     * @ORM\Id @ORM\Column(type="integer", name="Id_Tipo_Usuario") @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\Column(type="string", name="Tipo_Usuario")
     */
    private $tipoUsuario;
    
    function __construct($tipoUsuario) {
        $this->tipoUsuario = $tipoUsuario;
    }

    
    function getId() {
        return $this->id;
    }

    function getTipoUsuario() {
        return $this->tipoUsuario;
    }

    function setTipoUsuario($tipoUsuario) {
        $this->tipoUsuario = $tipoUsuario;
    }


}

?>