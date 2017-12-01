<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//include '../Persistencia/DBConexion.php'; 
include '../Persistencia/helperCandidato.php';
    
    $datos = $_GET['datos'];
    $method = $_SERVER['REQUEST_METHOD'];
    /*
     * De todo lo que envio el cliente busca un llave especifica por cuestiones
    de seguridad.
     */
    $option = basename(filter_input(INPUT_GET, 'option', FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW));
    
    /*
     * 
     */
    if($method == "GET" || $option == "candidatosNoAceptados" ){
        $mHelperCandidato = new HelperCandidato();
        echo $mHelperCandidato->getCandidatosNoAceptados();
        
    }
    
    
    
?>