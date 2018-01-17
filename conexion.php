<?php

 /*function open_connection(){

	/* Definimos cada uno de los parametros necesarios para establecer la conexión 

		$server_name: Nombre del servidor.
		$user_name: usuario del gestor mysql
		$password: contraseña del gestor mysql si tiene 
		$enlace: Objeto que obtiene la conexión por medio del método: mysql_connect()

	

	$server_name = 'localhost';
	$user_name = 'root';
	$password = '';
	$database_name = 'Productos';
	$enlace;


	$enlace =  mysql_connect($server_name, $user_name, $password);
	if (!$enlace) {
		die('No pudo conectarse: ' . mysql_error());
	}

	// Seleccionamos la base de datos la cual vamos a untilizar

	$bd_seleccionada = mysql_select_db($database_name, $enlace);
	mysql_set_charset('utf8');

	if (!$bd_seleccionada) {
		die ('No se puede usar la base de datos que intenta seleccionar: ' . mysql_error());
	}

	return $enlace;
	
	}*/
	class DataBase
	{
		
		private static $_driver = DRIVER;
		private static $_port = PORT;
		private static $_server = SERVER;
		private static $_dbname = DBNAME;
		private static $_user = USER;
		private static $_password = PASSWORD;
		private static $_connect;

		private function DataBase(){}

		public static function getInstance(){

			$dsn = self::$_driver.":host=".self::$_server.":".self::$_port.";dbname=".self::$_dbname;

			if (!isset(self::$_connect)) {

				self::$_connect = new PDO($dsn, self::$_user, self::$_password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'', PDO::ATTR_PERSISTENT=>TRUE));
				self::$_connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			}
			return self::$_connect;
			
		}

		public function __clone(){
			trigger_error('No podras clonarla.',E_USER_ERROR);
		}
	}
	
?>