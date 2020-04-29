<?php
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="usuarios")
 */
class Usuario {
    /**
     * @ORM\Id @ORM\Column(type="integer", name="Id_Usuario") @ORM\GeneratedValue
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", name="Email")
     */
    private $email;

    

    /**
     * @ORM\Column(type="string", name="Apellido1")
     */
    private $apellido1;

    /**
     * @ORM\Column(type="string", name="Apellido2")
     */
    private $apellido2;

    /**
     * @ORM\Column(type="string", name="Nombre")
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", name="Confirmacion")
     */
    private $confirmacion;

    /**
     * @ORM\Column(type="string", name="Estado")
     */
    private $estado;

    /**
     * @ORM\Column(type="string", name="Caducidad_Suscripcion")
     */
    private $caducidadSuscripcion;

    /**
     * @ORM\Column(type="string", name="Contraseña")
     */
    private $contraseña;

    /**
     * @ORM\ManyToOne(targetEntity="TipoUsuario")
     * @ORM\JoinColumn(name="Tipo_Usuario",referencedColumnName="Id_Tipo_Usuario")
     */
    private $tipoUsuario;

     /**
     * @ORM\ManyToMany(targetEntity="Equipo", inversedBy="usuarios")
     * @ORM\JoinTable(name="favoritos_equipos", joinColumns={@ORM\JoinColumn(name="Usuario", referencedColumnName="Id_Usuario")},
     * inverseJoinColumns={@ORM\JoinColumn(name="Equipo", referencedColumnName="Id_Equipo")})
     */
    private $equiposFavoritos;
    /**
     * @ORM\ManyToMany(targetEntity="Jugador", inversedBy="usuarios")
     * @ORM\JoinTable(name="favoritos_jugadores", joinColumns={@ORM\JoinColumn(name="Usuario", referencedColumnName="Id_Usuario")},
     * inverseJoinColumns={@ORM\JoinColumn(name="Jugador", referencedColumnName="Id_Jugador")})
     */
    private $jugadoresFavoritos;

    /**
     * @ORM\ManyToMany(targetEntity="CuerpoTecnico", inversedBy="usuarios")
     * @ORM\JoinTable(name="favoritos_cuerpo_tecnico", joinColumns={@ORM\JoinColumn(name="Usuario", referencedColumnName="Id_Usuario")},
     * inverseJoinColumns={@ORM\JoinColumn(name="Cuerpo_Tecnico", referencedColumnName="Id_Cuerpo_Tecnico")})
     */
    private $tecnicosFavoritos;
    
    
    function __construct($email, $contraseña, $tipoUsuario,$confirmacion,$nombre,$apellido1,$estado='NC') {
        $this->email = $email;
        $this->contraseña = $contraseña;
        $this->tipoUsuario = $tipoUsuario;
        $this->confirmacion=$confirmacion;
        $this->estado=$estado;
        $this->nombre=$nombre;
        $this->apellido1=$apellido1;
        $this->jugadoresFavoritos=new Doctrine\Common\Collections\ArrayCollection();
        $this->equiposFavoritos=new Doctrine\Common\Collections\ArrayCollection();
        $this->tecnicosFavoritos=new Doctrine\Common\Collections\ArrayCollection();
    }

    
    function getId() {
        return $this->id;
    }

    function getNombreUsuario() {
        return $this->nombreUsuario;
    }

    function getEmail() {
        return $this->email;
    }

    function getContraseña() {
        return $this->contraseña;
    }

    function getTipoUsuario() {
        return $this->tipoUsuario;
    }

    function getEquiposFavoritos() {
        return $this->equiposFavoritos;
    }

    function getJugadoresFavoritos() {
        return $this->jugadoresFavoritos;
    }

    function getTecnicosFavoritos() {
        return $this->tecnicosFavoritos;
    }

    function getConfirmacion() {
        return $this->confirmacion;
    }

    function getEstado() {
        return $this->estado;
    }

    
    function getNombre() {
        return $this->nombre;
    }
    
    function getApellido1() {
        return $this->apellido1;
    }

    
    function getApellido2() {
        return $this->apellido2;
    }

    function getCaducidadSuscripcion() {
        return $this->caducidadSuscripcion;
    }

    function setNombreUsuario($nombreUsuario) {
        $this->nombreUsuario = $nombreUsuario;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setConfirmacion($confirmacion) {
        $this->confirmacion = $confirmacion;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setContraseña($contraseña) {
        $this->contraseña = $contraseña;
    }

    function setTipoUsuario($tipoUsuario) {
        $this->tipoUsuario = $tipoUsuario;
    }

    function setEquiposFavoritos($equiposFavoritos) {
        $this->equiposFavoritos = $equiposFavoritos;
    }

    function setJugadoresFavoritos($jugadoresFavoritos) {
        $this->jugadoresFavoritos = $jugadoresFavoritos;
    }

    function setCaducidadSuscripcion($caducidadSuscripcion) {
        $this->caducidadSuscripcion = $caducidadSuscripcion;
    }

    function setTecnicosFavoritos($tecnicosFavoritos) {
        $this->tecnicosFavoritos = $tecnicosFavoritos;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setApellido1($apellido1) {
        $this->apellido1 = $apellido1;
    }

    function setApellido2($apellido2) {
        $this->apellido2 = $apellido2;
    }


}
    ?>