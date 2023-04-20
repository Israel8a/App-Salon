<?php
namespace Model;
class Usuarios extends ActiveRecord{
    protected static $tabla = "usuarios";
    protected static $columnasDB=["id","nombre","apellido","email","password","telefono","admi","confirmar","token"];
    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admi;
    public $confirmar;
    public $token;
    public function __construct($args =[]){
        $this->id=$args["id"]?? null;    
        $this->nombre=$args["nombre"]?? "";
        $this->apellido=$args["apellido"]?? "";
        $this->email=$args["email"]?? "";
        $this->password=$args["password"]?? "";
        $this->telefono=$args["telefono"]?? "";
        $this->admi=$args["admi"]?? "0";
        $this->confirmar=$args["confirmar"]?? "0";
        $this->token=$args["token"]?? "";    
    }
    public function validar(){
        if (!$this->nombre) {
            self::$alertas["error"][]="El Nombre es Obligatorio";
        }
        if (!$this->apellido) {
            self::$alertas["error"][]="EL Apellido es Obligatorio";
        }
        if (!$this->telefono) {
            self::$alertas["error"][]="EL Telefono es Obligatorio";
        }
        if (!$this->email) {
            self::$alertas["error"][]="EL E-mail es Obligatorio";
        }
        if (!$this->password) {
            self::$alertas["error"][]="EL Password es Obligatorio";
        }
        if (strlen($this->password)<6) {
            self::$alertas["error"][]="EL Password Debe Contener al menos 6 caracteres";
        }
        return self::$alertas;
    }
    public function validarLogin(){
        if(!$this->email){
            self::$alertas["error"][]="El email es obligatorio";
        }
        if(!$this->password){
            self::$alertas["error"][]="El password es obligatorio";
        }
        return self::$alertas;
    }
    public function validarEmail(){
        if(!$this->email){
            self::$alertas["error"][]="El email es obligatorio";
        }
        return self::$alertas;
    }
    public function validarPassword(){
        if(!$this->password){
            self::$alertas["error"][]="El password es obligatorio";
        }
        if (strlen($this->password)<6) {
            self::$alertas["error"][]="EL Password Debe Contener al menos 6 caracteres";
        }
        return self::$alertas;
    }
    public function existeUsuario(){
        $query = "SELECT * FROM ".self::$tabla." WHERE email='".$this->email."'";
        $resultado = self::$db->query($query);
        if ($resultado->num_rows) {
            self::$alertas["error"][]="el usuario ya esta registrado";
        }
        return $resultado;
    }
    public function hashPassword(){
        $this->password = password_hash($this->password,PASSWORD_BCRYPT);
    }
    public function crearToken(){
        $this->token= uniqid();
    }
    public function verificarPasswordAndVerificado($authPassword){
        $resultado = password_verify($authPassword,$this->password);
        
        if(!$this->confirmar||!$resultado){
            self::$alertas["error"][]="Password incorrecto o tu cuenta no a sido confirmada";
        }else{
            return true;
        }
    }
}