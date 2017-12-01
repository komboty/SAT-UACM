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



    $option = $_GET['option'];
    $datos = $_GET['datos'];
    
    if($_SERVER['REQUEST_METHOD'] == "GET" && $option == 'candidatosNoAceptados'){
        
        
        $sql = "SELECT * FROM CANDIDATO";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
        // output data of each row
            $json= array();
            while($reg = $result->fetch_assoc()) {
            
                $myObj = array(
                    'IDCANDIDATO' => $reg['IDCANDIDATO'],
                     'IDASESOR' => $reg['IDASESOR'],
                     'IDGRUPO' => $reg['IDGRUPO'],
                     'FOTO' => $reg['FOTO'],
                     'NOMBRE' => $reg['NOMBRE'],
                     'APELLIDOPATERNO' => $reg['APELLIDOPATERNO'],
                     'APELLIDOMATERNO' => $reg['APELLIDOMATERNO'],
                     'CONTRASENA' => $reg['CONTRASENA'],
                     'MATRICULA' => $reg['MATRICULA'],
                     'EMAIL' => $reg['EMAIL'],
                     'CELULAR' => $reg['CELULAR'],
                     'CARRERA' => $reg['CARRERA'],
                     'CREDITOS' => $reg['CREDITOS'],
                     'TEMADETESIS' => $reg['TEMADETESIS'],               
                     'DIRECTORDETESIS' => $reg['DIRECTORDETESIS'],
                     'LUGARTRABAJO' => $reg['LUGARTRABAJO'],
                     'HORARIOTRABAJO' => $reg['HORARIOTRABAJO'],
                     'CARTACOMPROMISO' => $reg['CARTACOMPROMISO'],
                     'CARTAEXPOMOTIVOS' => $reg['CARTAEXPOMOTIVOS']
                
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