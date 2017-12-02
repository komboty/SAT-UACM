<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../Persistencia/DBConnection.php';

    $datos = $_GET['datos'];
    $method = $_SERVER['REQUEST_METHOD'];
    
    $option = basename(filter_input(INPUT_GET, 'option', FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW));
    
    if($method == "GET" && $option == 'candidatosNoAceptados'){
            
        $conn = new Connection();
        $sql = "SELECT * FROM CANDIDATO WHERE IDGRUPO IS NULL";
        $result = $conn->db_query($sql);

        if ($result->num_rows > 0) {
        // output data of each row
            $json= array();
            while($reg = $result->fetch_assoc()) {
                
                $myObj = array(
                    'idcandidato' => $reg['IDCANDIDATO'],
                     'idasesor' => $reg['IDASESOR'],
                     'idgrupo' => $reg['IDGRUPO'],
                     'foto' => "",
                     'nombre' => $reg['NOMBRE'],
                     'apellidoPaterno' => $reg['APELLIDOPATERNO'],
                     'apellidoMaterno' => $reg['APELLIDOMATERNO'],
                     'contrasena' => $reg['CONTRASENA'],
                     'matricula' => $reg['MATRICULA'],
                     'email' => $reg['EMAIL'],
                     'celular' => $reg['CELULAR'],
                     'carrera' => $reg['CARRERA'],
                     'creditos' => $reg['CREDITOS'],
                     'tematesis' => $reg['TEMADETESIS'],               
                     'directorDeTesis' => $reg['DIRECTORDETESIS'],
                     'ugarTabajo' => $reg['LUGARTRABAJO'],
                     'horarioTrabajo' => $reg['HORARIOTRABAJO'],
                     'cartaCompromiso' => "",
                     'cartaExpoMotivos' => ""
                    
                );
                if($reg['CARTACOMPROMISO'] == NULL){
                    
                   $myObj['cartaCompromiso'] = "0";
                          
                }else {
                    $myObj['cartaCompromiso'] = "1";
                }
                if($reg['CARTAEXPOMOTIVOS'] == NULL){
                    
                   $myObj['cartaExpoMotivos'] = "0";
                          
                }else {
                    $myObj['cartaExpoMotivos'] = "1";
                }
                  
                array_push($json, $myObj);
                }
            } else {
            echo "0 results";
            }
            //$conn->close();
            echo json_encode($json, JSON_FORCE_OBJECT);
        }
        
        if($method == "GET" && $option == 'getFoto'){
            
        $conn = new Connection();
        $sql = "SELECT FOTO FROM CANDIDATO WHERE IDCANDIDATO = ".$datos;
        $result = $conn->db_query($sql);
        
        if ($result->num_rows > 0) {
        // output data of each row
            $imgData = $result->fetch_assoc();
        
            //Render image
            header("Content-type: image/jpg"); 
            echo $imgData['FOTO']; 
            } else {
            echo "0 results";
            }
            //$conn->close();
            
        }
    
    ?>