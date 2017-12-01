<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DBConexion {
    private $dbServerName = "sql3.freemysqlhosting.net";
    private $dbUsername = "sql3208221";
    private $dbPassword = "lPMsPBIfZs";
    private $dbName = "sql3208221";
    private $conexion;
    
    function __construct() {
        $this->conexion = new mysqli($this->dbServerName, $this->dbUsername, $this->dbPassword, $this->dbName);
        echo 'Entre al constructor DBConexion';
        if(!$this->conexion) {
            echo 'No pude conectarme y entre al die';
            die('Javier Entre al error Error de conexión ('.mysqli_connect_errno().') '.mysqli_connect_error());
        }        
    }
    
    //Consulta a la base de datos.
    function consulta($consulta){
    //return mysqli_query($this->conexion, $consulta); 
      return $this->conexion->query($consulta);
    }
    
    //Devuelve el id del último insert.
    function ultimoInsert(){
        return mysqli_insert_id($this->conexion);
    }
        
    //Cierra la conexión.
    function cerrar(){
        mysqli_close($this->conexion);
    }
}
/*$dbServerName = "sql3.freemysqlhosting.net";
$dbUsername = "sql3208221";
$dbPassword = "lPMsPBIfZs";
$dbName = "sql3208221";
// create connection
$conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);
// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}*/
?>
