<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$dbServerName = "sql3.freemysqlhosting.net";

$dbUsername = "sql3208221";
$dbPassword = "lPMsPBIfZs";
$dbName = "sql3208221";

// create connection
$conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);

// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



   // $option = $_GET['option'];
    $datos = $_GET['datos'];
    $method = $_SERVER['REQUEST_METHOD'];
    /*
     * De todo lo que envio el cliente busca un llave especifica por cuestiones
    de seguridad.
     */
    $option = basename(filter_input(INPUT_GET, 'option', FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW));
    
    if($method == "GET" && $option == 'candidatosNoAceptados'){
        
        
        $sql = "SELECT * FROM CANDIDATO WHERE IDGRUPO IS NULL";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
        // output data of each row
            $json= array();
            while($reg = $result->fetch_assoc()) {
            
                $myObj = array(
                    'idcandidato' => $reg['IDCANDIDATO'],
                     'idasesor' => $reg['IDASESOR'],
                     'idgrupo' => $reg['IDGRUPO'],
                     'foto' => $reg['FOTO'],
                     'nombre' => $reg['NOMBRE'],
                     'apellidoPaterno' => $reg['APELLIDOPATERNO'],
                     'apellidoMaterno' => $reg['APELLIDOMATERNO'],
                     'contrasena' => $reg['CONTRASENA'],
                     'matricula' => $reg['MATRICULA'],
                     'email' => $reg['EMAIL'],
                     'celular' => $reg['CELULAR'],
                     'carrera' => $reg['CARRERA'],
                     'credito' => $reg['CREDITOS'],
                     'tematesis' => $reg['TEMADETESIS'],               
                     'directorDeTesis' => $reg['DIRECTORDETESIS'],
                     'ugarTabajo' => $reg['LUGARTRABAJO'],
                     'horarioTrabajo' => $reg['HORARIOTRABAJO'],
                     'cartaCompromiso' => $reg['CARTACOMPROMISO'],
                     'cartaExpoMotivos' => $reg['CARTAEXPOMOTIVOS']
                
                );
                  
                array_push($json, $myObj);
                }
            } else {
            echo "0 results";
            }
            $conn->close();
            echo json_encode($json, JSON_FORCE_OBJECT);
        }
        if($_SERVER['REQUEST_METHOD'] == "GET" && $option == 'candidatos'){
        
        
        $sql = "SELECT * FROM CANDIDATO";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
        // output data of each row
            $json= array();
            while($reg = $result->fetch_assoc()) {
            
                $myObj = array(
                    'idcandidato' => $reg['IDCANDIDATO'],
                     'idasesor' => $reg['IDASESOR'],
                     'idgrupo' => $reg['IDGRUPO'],
                     'foto' => $reg['FOTO'],
                     'nombre' => $reg['NOMBRE'],
                     'apellidoPaterno' => $reg['APELLIDOPATERNO'],
                     'apellidoMaterno' => $reg['APELLIDOMATERNO'],
                     'contrasena' => $reg['CONTRASENA'],
                     'matricula' => $reg['MATRICULA'],
                     'email' => $reg['EMAIL'],
                     'celular' => $reg['CELULAR'],
                     'carrera' => $reg['CARRERA'],
                     'credito' => $reg['CREDITOS'],
                     'tematesis' => $reg['TEMADETESIS'],               
                     'directorDeTesis' => $reg['DIRECTORDETESIS'],
                     'ugarTabajo' => $reg['LUGARTRABAJO'],
                     'horarioTrabajo' => $reg['HORARIOTRABAJO'],
                     'cartaCompromiso' => $reg['CARTACOMPROMISO'],
                     'cartaExpoMotivos' => $reg['CARTAEXPOMOTIVOS']
                
                );
                  
                array_push($json, $myObj);
                }
            } else {
            echo "0 results";
            }
            $conn->close();
            echo json_encode($json, JSON_FORCE_OBJECT);
        }

?>