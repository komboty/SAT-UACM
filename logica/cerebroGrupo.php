<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cerebroGrupo
 *
 * @author vos
 */
include '../Persistencia/helperSeminarios.php';
    $helperSeminarios = new helperSeminarios();
    $datos = $_GET['datos'];
    $method = $_SERVER['REQUEST_METHOD'];

    $option = basename(filter_input(INPUT_GET, 'option', FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW));

    if ($method == "GET" && $option == 'grupos') {
        $helperSeminarios->getGrupos();
    }
    
    if ($method == "GET" && $option == 'unGrupo') {
        $helperSeminarios->getGrupo($datos);
    }
    
    if($method == "GET" && $option == 'getFoto'){
        $helperSeminarios->getFoto($datos);
    }
        
    if($method == "GET" && $option == 'getCartaCompromiso'){
        $helperSeminarios->getComprimiso($datos);
    }
    
    if($method == "GET" && $option == 'getCartaMotivos'){
        $helperSeminarios->getMotivos($datos);
    }