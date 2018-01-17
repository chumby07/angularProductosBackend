<?php

require_once 'Config.php';
require_once 'conexion.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');

if(isset($_GET['productos'])){
    mostrarProductos();
}elseif(isset($_GET['idProd'])){
    getProducto($_GET['idProd']);
}elseif(isset($_GET['registro'])){
    $datos = file_get_contents('php://input');
    $datos2 = json_decode($datos);
    registrarContacto($datos2);
}elseif(isset($_GET['tipos'])){
    listarTiposP();
}

 function mostrarProductos(){

    /*$query="SELECT * FROM Products";
    $resultado = mysql_query($query) or die(mysql_error());
    $productos = array();

    while($row = mysql_fetch_assoc($resultado)){
        $productos[] = $row;
    }*/

    $productos = array();
    $sth = DataBase::getInstance()->prepare("SELECT * FROM products");
    $sth->execute();

    $res = $sth->fetchAll();
    /*var_dump($sth);
    var_dump($res);*/

    foreach($res as $key => $value){

        $productos[] = $value;
        //echo $value["nombre"];

    }

    echo json_encode($productos);
}


function getProducto($id){

    $productos = array();
    $sth = DataBase::getInstance()->prepare("SELECT * FROM products WHERE idProd = $id");
    $sth->execute();

    $res = $sth->fetch();
    /*var_dump($sth);
    var_dump($res);*/


    echo json_encode($res);

}

function registrarContacto($datos){

    $correo = $datos->correo;
    $descripcion = $datos->descripcion;

    $sth = DataBase::getInstance()->prepare("INSERT INTO contacto(correo, descripcion) VALUES ('$correo', '$descripcion')");

    if($sth->execute()){
        echo "ok";
    }else{
        echo "false";
    }
    

}

function listarTiposP(){
    
    $tipoP = array();
    $sth = DataBase::getInstance()->prepare("SELECT * FROM tipopersona");
    $sth->execute();

    $res = $sth->fetchAll();

    foreach($res as $key => $value){

        $tipoP[] = $value;

    }

    echo json_encode($tipoP);
}



?>