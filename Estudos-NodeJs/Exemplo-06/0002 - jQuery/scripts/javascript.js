$(document).ready(iniciar);

function iniciar(){

    //alert("Olá jQuery!");

    //__________________________________________________________________________________________ SELECTORS

    //Altera a cor do elemento referenciado pelo id #p1
    // $("#p1").css('color', 'green');

    //Altera todos os elemtentos da DOM. selector * (all)
    // $("*").css('color','lightblue');

    //Altera a cor apenas nos element Selectors especificados <div>
    // $("div").css('color','red');

    //Altera a cor de um elemento referenciando sua classe .p1
    // $(".label").css('color','blue');

    //Selecionando através do atributo de um seletor (nesse caso todos os elementos que contem o atributo name)
    // $("[name]").css("color", "red");

    //Selecionar pelo atributo especificamente pelo valor
    // $("span[name='renato']").css("color", "red");

    //NÂO Selecionar pelo atributo especificamente pelo valor (atributo not !)
    // $("span[name!='renato']").css("color", "red");

    //Selecionar pelo atributo que COMEÇE com REN (atributo Starts with ^)
    // $("span[name^='ren']").css("color", "red");

    //Selecionar pelo atributo que TERMINE com ATO (atributo Starts with $)
    // $("span[name$='ato']").css("color", "red");

    //Selecionar pelo atributo que CONTENHA A (atributo Starts with *)
    // $("span[name*='at']").css("color", "red");

    //Selecionar pelo atributo que CONTENHA letra A (atributo Starts with ~)
    // $("span[name~='a']").css("color", "red");

    //Selector de formulários
    // $(":text").css("background-color", "yellow");
    // $("input[name='texto2']").css("background-color", "yellow");
    // $("input[value='enviar']").val("Este é o novo texto");


    // __________________________________________________________________________________________ EVENTOS

    $('#par2').click(function(){
        $('#par1').slideUp(1000);
    });

    $('#par3').hover(function(){
        $('#par2').toggle();
    });

    $('#par1').mousemove(function(){
        $('#par2').text("Mouse foi mexido!.");
    });

    $("#par4, #par5, #par6").mouseenter(function(){
        $(this).css("background-color","black").css("color","white");
    }).mouseleave(function(){
        $(this).css("background-color","lightblue").css("color","black");
    });

    $("form").submit(function(){return false;});

    $("input[name='texto1'],[name='texto2']").focusin(function(){
        $(this).css("background-color", "lightblue");
    }).focusout(function(){
        $(this).css("background-color", "white");
    });

    var e = $("#info");~
    $("input[name='texto1']").click(function(){e.text("Clicou no form!")})
                             .dblclick(function(){e.text("Clique duplo no form!")})
                             .mouseenter(function(){e.text("Mouse entrou no form!")})
                             .mouseleave(function(){e.text("Mouse saiu do form!")});

    //Usando Bind para passar argumentos - aula 031
                            //focusin(funcao).focusout(funcao);  
    $("input[name='texto1']").bind("focusin", {estado: true}, funcao);
    $("input[name='texto1']").bind("focusout", {estado: false}, funcao);
    
       

    // __________________________________________________________________________________________ FUNCTIONS

    //A função hide esconde o elemento referenciado pela arvore de selectors
     $("div p").hide();
    //Ao evocar o evento Click no SPAN contido no corpo do HTML, a função interna é executada.
     $('span').click(function(){
         $('div p').show();
     })

     //Usando Bind para passar argumentos - aula 031
     function funcao(estado){
        if(estado.data.estado)
            $(this).css("background-color", "yellow");
        else
            $(this).css("background-color", "white");
     }

    
}