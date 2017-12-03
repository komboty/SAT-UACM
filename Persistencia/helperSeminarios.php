<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of helperSeminarios
 *
 * @author vos
 */
include '../Persistencia/DBConnection.php';

class helperSeminarios {
    private $conexion;

    function __construct() {
        $this->conexion = new Connection();
    }

    //Regresa el número de grupos que hay en la base de datos.
    public function getGrupos(){        
        
        $query = "SELECT * FROM GRUPO";
        $result = $this->conexion->db_query($query);  
        
        $json = array();
        
        while($renglon = $result->fetch_assoc()){
            $myObj = array(
                'id' => $renglon["IDGRUPO"],
                'nombre' => $renglon["NOMBRE"],
                'semestre' => $renglon["SEMESTRE"],
            );
                
            array_push($json, $myObj);
        }
        
        echo json_encode($json, JSON_FORCE_OBJECT);
    }
    
    //Regresa los alumnos que estan en un grupo.
    public function getGrupo($id) {
        $sql = "SELECT * FROM CANDIDATO WHERE IDGRUPO = ".$id;
        $result = $this->conexion->db_query($sql);

        if ($result->num_rows > 0) {
        // output data of each row
            $json= array();
            while($reg = $result->fetch_assoc()) {
                
                $myObj = array(
                    'idcandidato' => $reg['IDCANDIDATO'],
                     'asesor' => $reg['IDASESOR'],
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
                 
                $myObj['asesor'] = $this->getNombreAsesor($myObj['asesor']); 
                
                array_push($json, $myObj);                 
            }
            echo json_encode($json, JSON_FORCE_OBJECT);
        }
    }
    
    //obtiene el nombre del asesor de un canddato.
    public function getNombreAsesor($id) {
        if($id == null){
            return;
        }
        
        $sql = "SELECT * FROM ASESOR WHERE IDASESOR = ".$id;
        $result = $this->conexion->db_query($sql);

        while($reg = $result->fetch_assoc()) {
            return $reg['NOMBRE'].' '.$reg['APELLIDOPATERNO'];
        }
    }
    
    //Regresa la foto de un candidato.
    public function getFoto($datos) { 
        $sql = "SELECT FOTO FROM CANDIDATO WHERE IDCANDIDATO = ".$datos;
        $result = $this->coconn->db_query($sql);
        
        if ($result->num_rows > 0) {
            $imgData = $result->fetch_assoc();
            
            header("Content-type: image/jpg"); 
            echo $imgData['FOTO']; 
        } else {
            echo "0 results";
        }
    }

    //regresa la carta compromiso de un candidato.
    public function getComprimiso($datos) {
        $sql = "SELECT CARTACOMPROMISO FROM CANDIDATO WHERE IDCANDIDATO = ".$datos;
        $result = $this->coconn->db_query($sql);
        
        if ($result->num_rows > 0) {
        // output data of each row
            $data = $result->fetch_assoc();
                    
            header("Content-type: image.pdf; charset=utf-8");
            echo $data['CARTACOMPROMISO']; 
        } else {
        echo "0 results";
        }
    }
    
    //regresa la carta exposición de motivos de un candidato.
    public function getMotivos($datos) {
        $sql = "SELECT CARTAEXPOMOTIVOS FROM CANDIDATO WHERE IDCANDIDATO = ".$datos;
        $result = $this->coconn->db_query($sql);
        
        if ($result->num_rows > 0) {
        // output data of each row
            $data = $result->fetch_assoc();
                    
            header("Content-type: image.pdf; charset=utf-8");
            echo $data['CARTAEXPOMOTIVOS']; 
        } else {
        echo "0 results";
        }
    }
}
