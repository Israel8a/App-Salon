<?php
namespace Clases;

use PHPMailer\PHPMailer\PHPMailer;


class Email{
    public $nombre;
    public $email;
    public $token;
    public function __construct($nombre,$email,$token){
        $this->nombre = $nombre;
        $this->email = $email;
        $this->token = $token;
    }
    public function enviarConfirmacion(){
        $email = new PHPMailer();
        $email->isSMTP();
        $email->Host = 'sandbox.smtp.mailtrap.io';
        $email->SMTPAuth = true;
        $email->Port = 2525;
        $email->Username = 'cfe6b6e5c4a9ea';
        $email->Password = '4cfe571efd43ba';
        $email->setFrom("cuentas@appsalon.com");
        $email->addAddress("cuentas@appsalon.com","AppSalon.com");
        $email->Subject="confirma tu cuenta";
        $email->isHTML(true);
        $email->CharSet="UTF-8";

        $contenido ="<html>";
        $contenido.="<p><strong>Hola ".$this->nombre."</strong> Has creado tu cuenta en app Salon, solo debes confirmarla presionando el siguiente enlace</p>";
        $contenido.="<p>Presione aqui: <a href='https://unisexaesthetic.herokuapp.com/confirmar-cuenta?token=".$this->token."'>Confirmar Cuenta</p></a>";
        $contenido.="<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
        $contenido.="</html>";
        $email->Body = $contenido;
        $email->send();
    }
    public function enviarInstrucciones(){
        $email = new PHPMailer();
        $email->isSMTP();
        $email->Host = 'sandbox.smtp.mailtrap.io';
        $email->SMTPAuth = true;
        $email->Port = 2525;
        $email->Username = 'cfe6b6e5c4a9ea';
        $email->Password = '4cfe571efd43ba';
        $email->setFrom("cuentas@appsalon.com");
        $email->addAddress("cuentas@appsalon.com","AppSalon.com");
        $email->Subject="Restablece tu password";
        $email->isHTML(true);
        $email->CharSet="UTF-8";

        $contenido ="<html>";
        $contenido.="<p><strong>Hola ".$this->nombre."</strong> Has solicitado reestablecer tu password, sigue el enlace para hacerlo</p>";
        $contenido.="<p>Presione aqui: <a href='https://unisexaesthetic.herokuapp.com/recuperar?token=".$this->token."'>Reestablecer Password</p></a>";
        $contenido.="<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
        $contenido.="</html>";
        $email->Body = $contenido;
        $email->send();
    }
}