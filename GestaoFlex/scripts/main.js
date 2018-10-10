// main.js

//=======================================================================
function gerarPassword(numLetras){
    //Gera uma password aleatoria
    let text_password = document.getElementById('text_password');

    let caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let codigo = '';
    for(let i=0; i < numLetras ; i++){
        let r = Math.floor( Math.random() * caracteres.length) + 1;
        codigo += caracteres.substr(r,1);
    }

    //coloca o código no campo da password
    text_password.value = codigo;    
    
}

//=======================================================================
function checks(estado){
    $('input:checkbox').prop('checked', estado);
}

//=======================================================================

// function preencheForm(){
//     aux.document.getElementsByName("text_cep");
//     document.write(document.getElementById("cep").value);
    
//     Endereco

//     let text_address = document.getElementsByName("text_address");
//     let text_neighborhood = document.getElementsByName("text_neighborhood");
//     let text_city = document.getElementsByName("text_city");
//     let text_uf = document.getElementsByName("text_uf");

//     text_address.setAttribute("value",address);
//     text_neighborhood.setAttribute("value",neighborhood);
//     text_city.setAttribute("value",city);
//     text_uf.setAttribute("value",uf);
// }

//=======================================================================

function trocaBotao(){
    var aux = document.getElementById('extend');

    //document.write(aux.getAttribute("class"));
    if(aux.getAttribute("class") == "svg-inline--fa fa-plus-square fa-w-14"){
        //document.write(aux.getAttribute("class"));
        aux.setAttribute("class", "svg-inline--fa fa-minus-square fa-w-14");
   
    } else{
        //document.write(aux.getAttribute("class"));
        aux.setAttribute("class", "svg-inline--fa fa-plus-square fa-w-14");

    }
}

//=======================================================================

$('#Ent').click(function(){
    $('#saida').collapse('hide');
    $('#cadastro').collapse('hide');
});

$('#Sai').click(function(){
    $('#entrada').collapse('hide');
    $('#cadastro').collapse('hide');
});

$('#Cad').click(function(){
    $('#saida').collapse('hide');
    $('#entrada').collapse('hide');
});

setTimeout(function() {
    $("#inp-suc").hide();
    $("#out-suc").hide();
    $("#reg-suc").hide();
}, 5000);

