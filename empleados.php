<?php

require_once 'Config.php';
require_once 'conexion.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');

if(isset($_GET['empleados'])){
    listarEmpleados();
}elseif(isset($_GET['regEmpleados']) and $_SERVER['REQUEST_METHOD'] != 'OPTIONS'){
    $datos = file_get_contents('php://input');
    $datos2 = json_decode($datos);
    registrarEmpleados($datos2);
}elseif(isset($_GET['listEmpleado'])){
    listarEmpleado($_GET['listEmpleado']);
}elseif(isset($_GET['modEmpleado']) and $_SERVER['REQUEST_METHOD'] != 'OPTIONS'){
    $datos = file_get_contents('php://input');
    $datos2 = json_decode($datos);
    modificarEmpleado($datos2);
}elseif(isset($_GET['delEmpleado'])){
    eliminarEmpleado($_GET['delEmpleado']);
}

function listarEmpleados(){

    $empleados = array();
    $sth = DataBase::getInstance()->prepare("SELECT * FROM empleados");
    $sth->execute();

    $res = $sth->fetchAll();
    /*var_dump($sth);
    var_dump($res);*/

    foreach($res as $key => $value){

        $empleados[] = $value;
        //echo $value["nombre"];

    }

    echo json_encode($empleados);

}

function registrarEmpleados($datos){

    $correo = $datos->correo;
    $nombre = $datos->nombre;
    $nit = $datos->nit;
    $telefono = $datos->telefono;

    $sth = DataBase::getInstance()->prepare("INSERT INTO empleados (nombre, nit, telefono, correo) VALUES ('$nombre', '$nit', '$telefono', '$correo')");

    if($sth->execute()){
        echo "ok";
    }else{
        echo "false";
    }
}

function listarEmpleado($id){

    $empleado = array();
    $sth = DataBase::getInstance()->prepare("SELECT * FROM empleados WHERE idEmpleado = $id");
    $sth->execute();

    $res = $sth->fetch();
    /*var_dump($sth);
    var_dump($res);*/

    echo json_encode($res);

}

function modificarEmpleado($datos){

    $idEmple = $datos->idEmpleado;
    $correo = $datos->correo;
    $nombre = $datos->nombre;
    $nit = $datos->nit;
    $telefono = $datos->telefono;

    $sth = DataBase::getInstance()->prepare("UPDATE empleados SET nombre='$nombre', nit='$nit', telefono='$telefono', correo='$correo' WHERE idEmpleado = $idEmple");

    if($sth->execute()){
        echo "ok";
    }else{
        echo "false";
    }

}

function eliminarEmpleado($id){

    $sth = DataBase::getInstance()->prepare("DELETE FROM empleados WHERE idEmpleado = $id");

    if($sth->execute()){
        echo "ok";
    }else{
        echo "false";
    }

}

?>