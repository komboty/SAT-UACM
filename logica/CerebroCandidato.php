<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * Creado por Javier Monroy Salcedo
 */
include '../Persistencia/DBConnection.php';
//include '../Persistencia/base/candidatoDBHelper.php';
    $option = basename(filter_input(INPUT_GET, 'option', FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW));
    if(($method = $_SERVER['REQUEST_METHOD'])== "GET"){
        $datos = $_GET['datos'];
        
    }
    if(($method = $_SERVER['REQUEST_METHOD'])== "POST"){
        $datos = $_POST['datos'];
        echo $method. "datos= ".$datos;
        echo $option;
        
    }
   
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
        if($method == "GET" && $option == 'getCartaCompromiso'){
            
        $conn = new Connection();
        $sql = "SELECT CARTACOMPROMISO FROM CANDIDATO WHERE IDCANDIDATO = ".$datos;
        $result = $conn->db_query($sql);
        
        if ($result->num_rows > 0) {
        // output data of each row
            $data = $result->fetch_assoc();
        
            //Render image
            //header("Content-type: image/pdf"); 
            header("Content-type: image.pdf; charset=utf-8");
            echo $data['CARTACOMPROMISO']; 
            } else {
            echo "0 results";
            }
            //$conn->close();
            
        }
        if($method == "GET" && $option == 'getCartaMotivos'){
            
        $conn = new Connection();
        $sql = "SELECT CARTAEXPOMOTIVOS FROM CANDIDATO WHERE IDCANDIDATO = ".$datos;
        $result = $conn->db_query($sql);
        
        if ($result->num_rows > 0) {
        // output data of each row
            $data = $result->fetch_assoc();
        
            //Render image
            //header("Content-type: image/pdf"); 
            header("Content-type: image.pdf; charset=utf-8");
            echo $data['CARTAEXPOMOTIVOS']; 
            } else {
            echo "0 results";
            }
            //$conn->close();
            
        }
        function existeGrupo($semestre){
            echo "semestre= ".$semestre;  
            $conn = new Connection();
            $sql = "SELECT IDGRUPO FROM GRUPO WHERE SEMESTRE = '".$semestre."'";
            echo "<br> sql= ".$sql;
            $result = $conn->db_query($sql);
            //echo $result;
            if ($result->num_rows > 0) {  
                echo "true";
            return true;  
            
            }else{
                echo "false";
                return false;
                
            }
        }
        
        if($method == "GET" && $option == 'insertCandidatoAceptado'){
            /*
             * Obteniendo la lista de candidatos aceptados
             */
            
            $idCandidato = $datos;
            $semestre = "2017 II";   
            $conn = new Connection();
            /*
             * Calculando el semestre en curso
             */
            $hoy = getdate();
            echo $hoy['month'];
            switch ($hoy['month']) {
           
                case 'January':
                case 'February':              
                case 'March':
                case 'April':
                case 'May':
                case 'June':                    
                    $semestre = $hoy['year']." I";
                    break;
                case 'July':
                case 'August':
                case 'September':
                case 'October':
                case 'November':
                case 'December': 
                    $semestre = $hoy['year']." II";
                break;
            }
            
        
        /*
         * Si no existe grupo para ese semestre se creara uno
         */
               
            if (!existeGrupo($semestre)) {
                $sql = "INSERT INTO `GRUPO`(`NOMBRE`, `SEMESTRE`) VALUES ('1','".$semestre."')";
                $result = $conn->db_query($sql);
                $sql = "SELECT IDGRUPO FROM GRUPO WHERE SEMESTRE = '".$semestre."'";
                $result = $conn->db_query($sql);
                $sql = "UPDATE `CANDIDATO` SET `IDGRUPO`= ".$result." WHERE IDCANDIDATO = ".$datos;
                $result = $conn->db_query($sql);
                echo "Candidato aceptado existosamente";
            }else {
                
                
                for($i = 1;$i< 30; $i++){
                    
                    $sql = "SELECT COUNT(IDCANDIDATO),IDGRUPO FROM CANDIDATO "
                            . "WHERE CANDIDATO.IDGRUPO ="
                            . "(SELECT IDGRUPO FROM GRUPO WHERE SEMESTRE = '"
                            . $semestre."' AND NOMBRE = '". $i."') GROUP BY CANDIDATO.IDGRUPO";
                    
                    $result = $conn->db_query($sql);
                    $reg = $result->fetch_assoc();
                    
                    
                    if($reg['COUNT(IDCANDIDATO)'] < 25){
                       
                        $sql = "UPDATE `CANDIDATO` SET `IDGRUPO` = '". $reg['IDGRUPO']
                                ."' WHERE IDCANDIDATO = '".$idCandidato."'";
                        $result = $conn->db_query($sql);
                        break;
                    }
                    
                }
               echo "Candidato aceptado con exito"; 
            }           
        }
        /*
         * verifica si un grupo existe para el semestre en curso
         */
        
        
    ?>