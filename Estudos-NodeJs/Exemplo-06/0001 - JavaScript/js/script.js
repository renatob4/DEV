var valoor = true; //aula 4

function iniciar(){
    document.getElementById("botao").onclick = ApresentarData;
}

function teste(){
    //Atribui o valor recebido ao elemento identificado pelo ID na DOM.
    document.getElementById('info').innerHTML = "Este é o texto de JavaScript";
}

function alterar(e){
    e.innerHTML = "---------";
}

function ApresentarData(){
    document.getElementById('date').innerHTML = Date();
}

function mouseOver(e){
    e.style.backgroundColor = "yellow";
}

function mouseOut(e){
    e.style.backgroundColor = "orange";
}

function clik(e){
    e.style.backgroundColor = "transparent";
    e.innerHTML = "Novo texto";
}

function DOMmanipulation()
{
    //document.getElementById('primeiro').innerHTML = "Buscar elemento da Dom pelo ID";
    //document.getElementsByClassName('uma').innerHTML = "Buscar elemento da Dom pela classe"; //Funciona capturando TODAS as tags com a mesma classe.

    //Outra forma de alterar a DOM
    // var elemento = document.getElementById('primeiro');
    // elemento.innerHTML = "Outra forma de alterar.";

    //Quando a captura for via classe, podemos alterar apenas a especificada no array.
    // var elemento = document.getElementsByClassName('uma');
    // elemento[2].innerHTML = "Texto novo.";

    // var elemento = document.getElementById("segundo");
    // elemento.style.color = "black";

    //AULA 3 DOM ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    //Modificar um elemento
    document.getElementById("p1").innerHTML = "Parágrafo 1 modificado.";

    //Modificar o estilo de um elemento
    var elemento = document.getElementById("p2");
    elemento.style.fontWeight = "bold";
    elemento.style.color = "blue";
    elemento.innerHTML = "Alterado para cor azul e texto negrito.";

    //Modificar visibilidade de um elemento
    var p3 = document.getElementById("p3");
    var p4 = document.getElementById("p4");
    p3.hidden = true;
    p4.innerHTML = "O paragrafo 3 foi escondido";

    //Modificar um atributo de um elemento
    var link = document.getElementById("link");
    link.setAttribute("class", "duas");
    link.setAttribute("href", "http://www.imdb.com");

    //Adicionar um atributo
    link.setAttribute("target", "_blank");

    //Adicionar um novo elemento á pagina
    var novo = document.createElement("p");
    document.body.appendChild(novo);
    novo.innerHTML = "NOVO ELEMENTO!";

    //mudar elemento entre divs
    var imagem = document.getElementById("imagem");
    document.getElementById("div2").appendChild(imagem);

    //AULA 4 DOM ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    
    //YES: https://cdn4.iconfinder.com/data/icons/generic-interaction/143/yes-tick-success-done-complete-check-allow-128.png
    //NO: http://www.iconhot.com/icon/png/quiet/128/no.png

    var elemento = document.getElementById("img");

    //Analisa a imagem apresentada
    if(valoor){
        elemento.setAttribute("src", "http://www.iconhot.com/icon/png/quiet/128/no.png");
        valoor = false;
    } else {
        elemento.setAttribute("src", "https://cdn4.iconfinder.com/data/icons/generic-interaction/143/yes-tick-success-done-complete-check-allow-128.png");
        valoor = true;
    }
}

function StringFunctions(){

    var texto = 'Renato Rodrigues da Costa';

    //lenght 
    // - captura o comprimento total da string
    // document.getElementById('info').innerHTML = texto.length;

    //charAt() 
    // - Retorna/verifica o caracter (10) que esta na posição passada como argumento.
    // var valor = texto.charAt(12);
    // document.getElementById('info').innerHTML = valor;

    //includes()
    // - Retorna TRUE ou FALSE de acordo com a permanencia do texto passado como argumento na string principal.
    // var valor = texto.includes('Renat');
    // document.getElementById('info').innerHTML = valor;

    //repeat()
    // - Repete o texto pela quantidade de vezes passada por argumento.
    // var texto = "Ups!";
    // var final = texto.repeat(10);
    // document.getElementById('info').innerHTML = final;

    //slice()
    // - Captura uma parte da string limitados pelo intervalo passado como parametro (no exemplo entre o caracter 4 e o 10).
    // var texto = "Esta frase é pequena";
    // var parte = texto.slice(4,15);
    // document.getElementById('info').innerHTML = parte;

    //toUpperCase()
    // - Formata todo o texto para Maiúsculas.
    // var texto = "este texto esta todo em minusculas?";
    // document.getElementById('info').innerHTML = texto.toUpperCase();

    //Lista completa de methodos
    //https://www.w3schools.com/jsref/jsref_obj_string.asp

}

