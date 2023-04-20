<?php
namespace Controllers;

use Model\Cita;
use Model\CitaServicios;
use Model\Servicios;

class APIControllers {
    public static function index(){
        $servicios = Servicios::all();
        echo json_encode($servicios);
    }
    public static function guardar(){
        //almacena la cita y devuelve el id
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();
        $id = $resultado["id"];
        //almacena la  cita y el servicio
        $idServicios = explode(",",$_POST["servicios"]);
        foreach($idServicios as $idServicio){
            $args=[
                "citaId"=>$id,
                "servicioId"=>$idServicio
            ];
            $citaServicio = new CitaServicios($args);
            $citaServicio->guardar();
        }
        echo json_encode(["resultado"=>$resultado]);
    }
    public static function eliminar(){
        if($_SERVER["REQUEST_METHOD"]==="POST"){
        $id = $_POST["id"];
        $cita = Cita::find($id);
        $cita->eliminar();
        header("Location:".$_SERVER["HTTP_REFERER"]);
        }
    }
}