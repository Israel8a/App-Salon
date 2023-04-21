<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\AdmiControllers;
use Controllers\APIControllers;
use Controllers\CitaControllers;
use Controllers\LoginControllers;
use Controllers\ServicioControllers;
use MVC\Router;

$router = new Router();
//Iniciar seccion
$router->get("/",[LoginControllers::class,"login"]);
$router->post("/",[LoginControllers::class,"login"]);
$router->get("/logout",[LoginControllers::class,"logout"]);
//recuperar contraseña
$router->get("/olvide",[LoginControllers::class,"olvide"]);
$router->post("/olvide",[LoginControllers::class,"olvide"]);
$router->get("/recuperar",[LoginControllers::class,"recuperar"]);
$router->post("/recuperar",[LoginControllers::class,"recuperar"]);
//crear cuenta
$router->get("/crear-cuenta",[LoginControllers::class,"crear"]);
$router->post("/crear-cuenta",[LoginControllers::class,"crear"]);
//cuenta-valida
$router->get("/confirmar-cuenta",[LoginControllers::class,"confirmar"]);
$router->get("/mensaje",[LoginControllers::class,"mensaje"]);
//PRIVADO
$router->get("/cita",[CitaControllers::class,"index"]);
$router->get("/admin",[AdmiControllers::class,"index"]);
//API
$router->get("/api/servicios",[APIControllers::class,"index"]);
$router->post("/api/citas",[APIControllers::class,"guardar"]); 
$router->post("/api/elimiar",[APIControllers::class,"eliminar"]);
//appi servicios
//Crud de servicios 
$router->get("/servicios",[ServicioControllers::class,"index"]);
$router->get("/servicios/crear",[ServicioControllers::class,"crear"]);
$router->post("/servicios/crear",[ServicioControllers::class,"crear"]);
$router->get("/servicios/actualizar",[ServicioControllers::class,"actualizar"]);
$router->post("/servicios/actualizar",[ServicioControllers::class,"actualizar"]);
$router->post("/servicios/eliminar",[ServicioControllers::class,"eliminar"]);
// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();