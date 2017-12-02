/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
window.onload = function () {
    grupos();
};

function grupos() {

    $.ajax({
        url: "../logica/CerebroGrupo.php",
        type: "GET",
        data: {option: "grupos", datos: "null"}
    }).done(function (respu) {
        //console.log("respuesta : " + respu);
//        json = JSON.parse(respu);
        json = JSON.parse(respu);

        //se obtiene cuantos crupos hay registrados.
        var numGrupos = Object.keys(json).length;

        var secction = document.getElementById('grupos');
        //Crea una tabla para mostrar los grupos.
        var tabla = document.createElement("table");
        var tblBody = document.createElement("tbody");

        // Crea los rengolnes de la tabla.
        for (var i = 0; i < numGrupos; i++) {
            var renglon = document.createElement("tr");
            // Crea las celdas.
            //for (var j = 0; j < 3; j++) {
            var celda = document.createElement("td");
            var textoCelda = document.createTextNode(json[i]['id'] + " " + json[i]['nombre'] + " " + json[i]['semestre']);
            celda.onclick = function () {
                mostrar(this);
            };//this); };
            celda.appendChild(textoCelda);
            renglon.appendChild(celda);
            //}
            // agremagos a la tabla el renglon.
            tblBody.appendChild(renglon);
        }

        // agregamos todos los renglones a la tabla.
        tabla.appendChild(tblBody);
        secction.appendChild(tabla);
    });
}

function mostrar(tableCell) { //tableCell) {    
    //limpira tabla.
    /*while (tableCell.hasChildNodes()) {
        tableCell.removeChild(tableCell.lastChild);
    }*/
    var id = tableCell.innerHTML.substr(0,1);
    $.ajax({
        url: "../logica/cerebroGrupo.php",
        type: "GET",
        data: {option: "unGrupo", datos: id}
    }).done(function (respu) {
        //console.log("respuesta : " + respu);
        json = JSON.parse(respu);
        
        //insertando los candidatos en el documente html
        var infoSeccion = tableCell;        
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

            var cell0 = row0.insertCell(0);
            var cell1 = row1.insertCell(0);
            var cell2 = row2.insertCell(0);
            var cell3 = row3.insertCell(0);
            var cell4 = row4.insertCell(0);
            var cell5 = row5.insertCell(0);



            cell5.innerHTML = "Nombre: " + json[i]["nombre"] + " "
                    + json[i]["apellidoPaterno"] + " "
                    + json[i]["apellidoMaterno"];
            cell4.innerHTML = "Matricula: " + json[i]["matricula"];
            cell3.innerHTML = "Carrera: " + json[i]["carrera"];
            cell2.innerHTML = "Creditos: " + json[i]["creditos"] + "%";
            if (json[i]["cartaCompromiso"] == "1") {
                cell1.innerHTML = "Carta compromiso: ENTREGADA";
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
                cell0.innerHTML = "Carta de motivos: ENTREGADA";
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
            //cell0.innerHTML = "Carta de Motivos: "+ json[i]["cartaMotivos"];

            //agregando boton de validar candidato    
            var validarCandidato = document.createElement('BUTTON');
            validarCandidato.setAttribute("class", "validar");
            //validarCandidato.setAttribute("value",json[i]['idcandidato']);
            validarCandidato.setAttribute("name", "idBnt");
            // validarCandidato.setAttribute("id",json[i]['idcandidato']);

            validarCandidato.setAttribute("id", json[i]["idcandidato"]);
            validarCandidato.addEventListener("click", validarCandidatos);
            var t = document.createTextNode("Validar Candidato");
            // Create a text node
            validarCandidato.appendChild(t);
            div2.appendChild(validarCandidato);

            var br = document.createElement("br");


            var hr = document.createElement("hr");
            infoSeccion.appendChild(br);
            infoSeccion.appendChild(hr);

        }
    });
    
    function validarCandidatos(){
        //algo = request.getParameter("idBnt");
        //recuerpando el id del candidato sobre el que dieron click
        alert(this.id);
    }
    function getCartaMotivos(){
        alert(this.id);
    }
    function getCartaCompromiso(){
        alert(this.id);
    }
}