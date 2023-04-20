<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}
function esUltimo(string $actual,string $siguiente):bool{
    if($actual !==$siguiente){
        return true;
    }
    return false;
}
// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}
//revisar si esta autenticado
function isAuth():void{
    if(!isset($_SESSION["login"])){
        header("Location: /");
    }
}
function isAdmin(){
    if(!isset($_SESSION["admi"])){
        header("Location:/");
    }
}