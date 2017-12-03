/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * Creado por Javier Monroy Salcedo
 * last update hoy
 */

window.onload = function() {
    submit = document.getElementById("boton");
    getCandidatosNoRegistrados();
}
            /*
             * realiza un consulta a la base de datos de todos los candidatos
             * no registrados y crea una lista donde se pueden  visualizar
             * asi como botones para accesar a sus respectivas cartas compromiso
             * y de motivos 
             * @returns {undefined}
             */
function getCandidatosNoRegistrados(){
                
                   
    $.ajax({
        url: "../logica/CerebroCandidato.php",
        type: "GET",
        data: { option: "candidatosNoAceptados",datos:"null" }
    }).done(function(respu){
        console.log("respuesta : " + respu);
        info = document.getElementById("info");                  
        json = JSON.parse(respu);
        console.log("nombre:"+ json[0]["nombre"]);
                    
    /*
    * insertando los candidatos en el documente html
    */
        var infoSeccion = document.getElementById("infoSeccion");
        var count = Object.keys(json).length;
        /*
         * En este for se agregan a los candidatos no aceptados dinamicamente
         * se crean aqui los componentes html necesarios para su inclusion
         * @type Number
         */
        for(var i = 0; i < count; i++){
            var div = document.createElement("div");
            div.setAttribute("id","contener"+json[i]['idcandidato']);
            
            infoSeccion.appendChild(div);
           
            var div2 = document.getElementById("contener"+json[i]['idcandidato']);
             
        //agregando la foto
            foto = document.createElement("IMG");//?option=getFoto&datos=8
            foto.setAttribute("src","../logica/CerebroCandidato.php?option=getFoto&datos="+json[i]["idcandidato"]);
            //foto.setAttribute("src","https://www.imagejournal.org/wp-content/uploads/bb-plugin/cache/23466317216_b99485ba14_o-panorama.jpg");
            foto.setAttribute("width","175");//width="175" height="200"
            foto.setAttribute("width","200");
            div2.appendChild(foto);
        // se agregando los datos del candidato a una tabla
            var table = document.createElement('table');
            table.setAttribute("id","table"+(i+1));
            div2.appendChild(table);
            table2 = document.getElementById("table"+(i+1));
                           
            var row0 = table2.insertRow(0);
            var row1 = table2.insertRow(0);
            var row2 = table2.insertRow(0);
            var row3 = table2.insertRow(0);
            var row4 = table2.insertRow(0);
            var row5 = table2.insertRow(0);
                            
            var cell0 =row0.insertCell(0);
            var cell1 =row1.insertCell(0);
            var cell2 =row2.insertCell(0);
            var cell3 =row3.insertCell(0);
            var cell4 =row4.insertCell(0);
            var cell5 =row5.insertCell(0);
            cell5.innerHTML ="Nombre: " + json[i]["nombre"]+ " "
                        +json[i]["apellidoPaterno"]+ " "
                        +json[i]["apellidoMaterno"];
            cell4.innerHTML = "Matricula: " + json[i]["matricula"];
            cell3.innerHTML = "Carrera: "+ json[i]["carrera"];
            cell2.innerHTML = "Creditos: " + json[i]["creditos"]+"%";
            if(json[i]["cartaCompromiso"]== "1"){
                cell1.innerHTML= "Carta compromiso: ENTREGADA";
                var btCartaComp = document.createElement('BUTTON');
                btCartaComp.setAttribute("class","cCompromiso");                           
                btCartaComp.setAttribute("name","BntCC");
                btCartaComp.setAttribute("id",json[i]["idcandidato"]);
                btCartaComp.addEventListener("click",getCartaCompromiso);
            var t = document.createTextNode("Ver carta compromiso");  
        // Create a text node
            btCartaComp.appendChild(t);
            div2.appendChild(btCartaComp);
            }else {
                cell1.innerHTML= "Carta compromiso: NO ENTREGADA";
            }
            // cell1.innerHTML = "Carta Compromiso: "+json[i]["cartaCompromiso"] ;
            if(json[i]["cartaExpoMotivos"]== "1"){
            //creando un boton para accesar al documento pdf
                cell0.innerHTML= "Carta de motivos: ENTREGADA";
                var btCartaComp = document.createElement('BUTTON');
                btCartaComp.setAttribute("class","cMotivos");                           
                btCartaComp.setAttribute("name","BntCC");
                btCartaComp.setAttribute("id",json[i]["idcandidato"]);
                btCartaComp.addEventListener("click",getCartaMotivos);
                var t = document.createTextNode("Ver carta motivos");  
            // Create a text node
                btCartaComp.appendChild(t);
                div2.appendChild(btCartaComp);
                                
            }else {
                cell0.innerHTML= "Carta de motivos: NO ENTREGADA";
            }
            //si el cnadidato cumple con tener carta compromiso y carta motivos 
            //se le podra agregar a un grupo
            if(json[i]["cartaCompromiso"]== "1" && json[i]["cartaExpoMotivos"]== "1"){   
                        
                var br = document.createElement("br"); 
                infoSeccion.appendChild(br);
                var validarCandidato = document.createElement('BUTTON');
                validarCandidato.setAttribute("class","validar");
            //validarCandidato.setAttribute("value",json[i]['idcandidato']);
                validarCandidato.setAttribute("name","idBnt");
            // validarCandidato.setAttribute("id",json[i]['idcandidato']);
                        
                validarCandidato.setAttribute("id",json[i]["idcandidato"]);
                validarCandidato.addEventListener("click",validarCandidatos);
                var t = document.createTextNode("Validar Candidato");  
            // Create a text node
                validarCandidato.appendChild(t);
                div2.appendChild(validarCandidato);
            }
            var br = document.createElement("br");                       
            var hr = document.createElement("hr");    
            infoSeccion.appendChild(br);
            infoSeccion.appendChild(hr);
               
        }
            //agregando eventos a los botones de cada candidato
            
    });
}
    //el envia el id de un candidato para ser agregado a un candidato
function validarCandidatos(){
   
    var div = document.getElementById("contener"+this.id);
     
    
   $.ajax({
        url: "../logica/CerebroCandidato.php",
        type: "GET",
        data: { option: "insertCandidatoAceptado",datos:this.id }
    }).done(function(respu){
            //alert(respu);
        console.log(respu);
       alert(respu);
     if (div.style.display === "none") {
        div.style.display = "block";
    } else {
        div.style.display = "none";
    } 
    });
}
    /*
     * obtiene la carta de motivos del candidato para su visualizacion
     */
function getCartaMotivos(){
        
    window.open("../logica/CerebroCandidato.php?option=getCartaMotivos&datos="+this.id);
        
}
/*
* obtieve la carta compromiso del candidato para su visualizacion
*/
function getCartaCompromiso(){
      
    window.open("../logica/CerebroCandidato.php?option=getCartaCompromiso&datos="+this.id);
         
}
