<?php
namespace Clases;

use PHPMailer\PHPMailer\PHPMailer;
use Dotenv\Dotenv as Dotenv;
$dotenv = Dotenv::createImmutable("../includes/.env");
$dotenv->safeLoad();

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
        $email->Host = $_ENV['MAIL_HOST'];
        $email->SMTPAuth = true;
        $email->Username = $_ENV['MAIL_USER'];
        $email->Password = $_ENV['MAIL_PASSWORD'];
        $email->SMTPSecure = 'tls';
        $email->Port = $_ENV['MAIL_PORT'];
        $email->setFrom("cuentas@appsalon.com");
        $email->addAddress("cuentas@appsalon.com","AppSalon.com");
        $email->Subject="confirma tu cuenta";
        $email->isHTML(true);
        $email->CharSet="UTF-8";

        $contenido ="<html>";
        $contenido.="<p><strong>Hola ".$this->nombre."</strong> Has creado tu cuenta en app Salon, solo debes confirmarla presionando el siguiente enlace</p>";
        $contenido.="<p>Presione aqui: <a href='http://localhost:3000/confirmar-cuenta?token=".$this->token."'>Confirmar Cuenta</p></a>";
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
        $email->Username = '9bbf6274e888f5';
        $email->Password = 'e2021028c58c95';
        $email->setFrom("cuentas@appsalon.com");
        $email->addAddress("cuentas@appsalon.com","AppSalon.com");
        $email->Subject="Restablece tu password";
        $email->isHTML(true);
        $email->CharSet="UTF-8";

        $contenido ="<html>";
        $contenido.="<p><strong>Hola ".$this->nombre."</strong> Has solicitado reestablecer tu password, sigue el enlace para hacerlo</p>";
        $contenido.="<p>Presione aqui: <a href='http://localhost:3000/recuperar?token=".$this->token."'>Reestablecer Password</p></a>";
        $contenido.="<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
        $contenido.="</html>";
        $email->Body = $contenido;
        $email->send();
    }
}