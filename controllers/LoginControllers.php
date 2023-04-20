<?php 
namespace Controllers;

use Clases\Email;
use Model\Usuarios;
use MVC\Router;

class LoginControllers{
    public static function login(Router $router){
        $alertas=[];
        $auth = new Usuarios;
        if($_SERVER["REQUEST_METHOD"]==="POST"){
            $auth= new Usuarios(($_POST));
            $alertas=$auth->validarLogin(); 
            if(empty($alertas)){
                //comprobar email
                $usuario = Usuarios::where("email",$auth->email);
                if($usuario){
                if($usuario->verificarPasswordAndVerificado($auth->password)){
                    session_start();
                    $_SESSION["id"] = $usuario->id;
                    $_SESSION["nombre"]= $usuario->nombre." ".$usuario->apellido;
                    $_SESSION["email"]= $usuario->email;
                    $_SESSION["login"]= true;
                    if($usuario->admi==="1"){
                    $_SESSION["admi"]= $usuario->admi ?? null;
                    header("Location: /admin");
                    debuguear($_SESSION);
                    }else{
                        header("Location: /cita");
                        debuguear($_SESSION);
                    }   
                };
                }else{
                    Usuarios::setAlerta("error","Usuario no encontrado");
                }
            }
        }
        $alertas = Usuarios::getAlertas();
        $router->render("auth/login",[
            "alertas"=>$alertas,
            "auth"=> $auth
        ]);
    }
    public static function logout(){
        session_start();
        $_SESSION = [];
        header("Location: /");
    }
    public static function olvide(Router $router){
        $alertas =[];
        if($_SERVER["REQUEST_METHOD"]==="POST"){
            $auth = new Usuarios($_POST);
            $alertas = $auth->validarEmail();
            if(empty($alertas)){
                $usuario = Usuarios::where("email",$auth->email);
                if ($usuario && $usuario->confirmar==="1") {
                    //crear toke y aguardaro
                    $usuario->crearToken();
                    $usuario->guardar();
                    //enviar email
                    $email = new Email($usuario->nombre,$usuario->email,$usuario->token);
                    $email->enviarInstrucciones();

                    //mensaje exito
                    Usuarios::setAlerta("exito","Revisa tu email");
                } else {
                    Usuarios::setAlerta("error","El usuario no existe o no esta confirmado");
                }
                
            }
        }
        $alertas = Usuarios::getAlertas();
        $router->render("auth/olvide-password",[
            "alertas"=> $alertas
        ]);
    }
    public static function recuperar(Router $router){
        $alertas =[];
        $token =$_GET["token"];
        $error = false;
        $usuario = Usuarios::where("token",$token);
        if(empty($usuario)){
            Usuarios::setAlerta("error","Token no Valido");
            $error=true;
        }
        if($_SERVER["REQUEST_METHOD"]==="POST"){
            $password = new Usuarios($_POST);
            $alertas=$password->validarPassword();
            if(empty($alertas)){
            $usuario->password=null;
            $password->hashPassword();
            $usuario->password = $password->password;
            $usuario->token=null;

            $resultado = $usuario->guardar();
            if($resultado){
                header("Location: /");
            }
            }
        }
        $alertas =Usuarios::getAlertas();
        $router->render("auth/recuperar-password",[
            "alertas"=> $alertas,
            "error"=> $error
        ]);
    }
    public static function crear(Router $router){
        $usuario = new Usuarios;
        $alertas = [];
        if($_SERVER["REQUEST_METHOD"]==="POST"){
            $usuario->sincronizar($_POST);
            $alertas=$usuario->validar();
            //verificar que alerta este vacia
            if(empty($alertas)){
                $resultado =$usuario->existeUsuario();
                if ($resultado->num_rows) {
                    $alertas = Usuarios::getAlertas();
                    
                } else {
                    $usuario->hashPassword();
                    $usuario->crearToken();
                    $email = new Email($usuario->nombre,$usuario->email,$usuario->token);
                    $email->enviarConfirmacion();
                    $resultado=$usuario->guardar();
                    if($resultado){
                        header("Location: /mensaje");
                    }
                }
                
            }
        }
        $router->render("auth/crear-cuenta",[
            "usuario" => $usuario,
            "alertas" => $alertas
        ]);
    }
    public static function mensaje(Router $router){
        $router->render("auth/mensaje",[

        ]);
    }
    public static function confirmar(Router $router){
        $alertas=[];
        $token=s($_GET["token"]);
        $usuario = Usuarios::where("token",$token);
        if (empty($usuario)) {
            Usuarios::setAlerta("error","Token no valido");
        } else {
            $usuario->token=NULL;
            $usuario->confirmar= "1";
            $usuario->guardar();
            Usuarios::setAlerta("exito","Cuenta comprobada correctamente");
        }
        $alertas = Usuarios::getAlertas();
        $router->render("auth/confirmar-cuenta",[
            "alertas"=> $alertas
        ]);
    }
}