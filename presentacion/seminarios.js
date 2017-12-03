/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
window.onload = function () {
    grupos();
};

json = '';

function grupos() {
    $.ajax({
        url: "../logica/CerebroGrupo.php",
        type: "GET",
        data: {option: "grupos", datos: "null"}
    }).done(function (respu) {
        //console.log("respuesta : " + respu);
//        json = JSON.parse(respu);
        json = JSON.parse(respu);
        crearOpciones();
    });
}

function crearOpciones() { 
    //se obtiene cuantos crupos hay registrados.
    var numGrupos = Object.keys(json).length;

    var select = document.getElementById('select');
    
    //se crea un una lista con los grupos que estan en la base de datos.
    //var select = document.createElement("SELECT");
    //select.setAttribute("id", "mySelect");
    select.onchange = function () { mostrar(); };
    //secction.appendChild(select);

    for (var i = 0; i < numGrupos; i++) {
        var opcion = document.createElement("option");
        opcion.setAttribute("value", json[i]['id']);        
        var nombre = document.createTextNode(json[i]['nombre'] + " " + json[i]['semestre']);
        opcion.appendChild(nombre);    
        select.appendChild(opcion);
    }
}

function mostrar() {    
    var id =  document.getElementById('select').value;
    var infoSeccion = document.getElementById("grup");
            
    //limpira los candidatos.
    while (infoSeccion.hasChildNodes()) {
        infoSeccion.removeChild(infoSeccion.lastChild);
    }       
    
    //si escoge la opción en blaco solo borrara la consulta anterior.
    if (id === ''){
        return;
    }
    //crearTabla()
    //Mensaje de cargando.
    var cargando = document.createElement('div');
    cargando.appendChild(document.createTextNode('Cargando...'));
    infoSeccion.appendChild(cargando);
    
    $.ajax({
        url: "../logica/cerebroGrupo.php",
        type: "GET",
        data: {option: "unGrupo", datos: id}
    }).done(function (respu) {
        //console.log("respuesta : " + respu);
        json = JSON.parse(respu);
        
        //se borra el mensaje de cargando.
        infoSeccion.removeChild(infoSeccion.lastChild);
        
        //insertando los candidatos en el documente html
        //var infoSeccion = document.getElementById("grup");
        
        var br = document.createElement("br");
        var hr = document.createElement("hr");
        infoSeccion.appendChild(br);
        infoSeccion.appendChild(hr);
        var count = Object.keys(json).length;
        for (var i = 0; i < count; i++) {
            var div = document.createElement("div");
            div.setAttribute("id", "contener" + (i + 1));
            infoSeccion.appendChild(div);
            var div2 = document.getElementById("contener" + (i + 1));
            //agregando la foto
            foto = document.createElement("IMG");
            foto.setAttribute("src", "../logica/cerebroGrupo.php?option=getFoto&datos=" + json[i]["idcandidato"]);            
            foto.setAttribute("width", "175");
            foto.setAttribute("width", "200");
            div2.appendChild(foto);
            //agregando los datos del candidato
            var table = document.createElement('table');
            table.setAttribute("id", "table" + (i + 1));
            div2.appendChild(table);
            table2 = document.getElementById("table" + (i + 1));

            var row0 = table2.insertRow(0);
            var row1 = table2.insertRow(0);
            var row2 = table2.insertRow(0);
            var row3 = table2.insertRow(0);
            var row4 = table2.insertRow(0);
            var row5 = table2.insertRow(0);
            var row6 = table2.insertRow(0);
            var row7 = table2.insertRow(0);

            var cell0 = row0.insertCell(0);
            var cell1 = row1.insertCell(0);
            var cell2 = row2.insertCell(0);
            var cell3 = row3.insertCell(0);
            var cell4 = row4.insertCell(0);
            var cell5 = row5.insertCell(0);
            var cell6 = row6.insertCell(0);
            var cell7 = row7.insertCell(0);

            var apPaterno = json[i]["apellidoPaterno"];
            var apMaterno = json[i]["apellidoMaterno"];
            
            cell7.innerHTML = "Tema de Tesis: " + json[i]["tematesis"];
            cell6.innerHTML = "Nombre: " + json[i]["nombre"] + " "
                    + apPaterno.substr(0,1) + " "
                    + apMaterno.substr(0,1);
            cell5.innerHTML = "Director de Tesis: " + json[i]["directorDeTesis"];
            cell4.innerHTML = "Asesor: " + json[i]["asesor"];
            cell3.innerHTML = "Carrera: " + json[i]["carrera"];
            cell2.innerHTML = "Creditos: " + json[i]["creditos"] + "%";
            if (json[i]["cartaCompromiso"] == "1") {
                //cell1.innerHTML = "Carta compromiso: ENTREGADA";
                var btCartaComp = document.createElement('BUTTON');
                btCartaComp.setAttribute("class", "cCompromiso");
                btCartaComp.setAttribute("name", "BntCC");
                btCartaComp.setAttribute("id", json[i]["idcandidato"]);
                btCartaComp.addEventListener("click", getCartaCompromiso);
                var t = document.createTextNode("Ver carta compromiso");
                // Create a text node
                btCartaComp.appendChild(t);
                div2.appendChild(btCartaComp);
            } else {
                cell1.innerHTML = "Carta compromiso: NO ENTREGADA";
            }
            
            if (json[i]["cartaExpoMotivos"] == "1") {
                //creando un boton para accesar al documento pdf
                //cell0.innerHTML = "Carta de motivos: ENTREGADA";
                var btCartaComp = document.createElement('BUTTON');
                btCartaComp.setAttribute("class", "cCompromiso");
                btCartaComp.setAttribute("name", "BntCC");
                btCartaComp.setAttribute("id", json[i]["idcandidato"]);
                btCartaComp.addEventListener("click", getCartaMotivos);
                var t = document.createTextNode("Ver carta motivos");
                // Create a text node
                btCartaComp.appendChild(t);
                div2.appendChild(btCartaComp);

            } else {
                cell0.innerHTML = "Carta de motivos: NO ENTREGADA";
            }

            var br = document.createElement("br");
            var hr = document.createElement("hr");
            infoSeccion.appendChild(br);
            infoSeccion.appendChild(hr);

        }
    });
    
    function getCartaMotivos(){
        window.open("../logica/CerebroCandidato.php?option=getCartaMotivos&datos="+this.id);        
    }
    function getCartaCompromiso(){
        window.open("../logica/CerebroCandidato.php?option=getCartaCompromiso&datos="+this.id);
    }
}