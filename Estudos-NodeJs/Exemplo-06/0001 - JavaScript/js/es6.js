//Desestruturação 
console.log("1. Exercicio de Desestruturação de objetos e arrays");

//forma antiga:
var nomes = ["Renato", "Ana", "Carlos"];
var n1 = nomes[0];
var n2 = nomes[1];
var n3 = nomes[2];

//forma nova (Desestruturação ES6):
var [nUm, nDois , nTres] = nomes;

//console.log(n1 + " - " + n2 + " - " + n3);
console.log(nUm + " - " + nDois + " - " + nTres);

//Desestruturação com objetos
let pessoa = {
    nm: "Renato",
    ida: 24,
    nacionalidade: "Brasileiro"
};

//forma antiga:
// let nm = pessoa.nm;
// let ida = pessoa.ida;

//forma nova (Desestruturação do objeto "pessoa" ES6):
let {nm, ida, nacionalidade} = pessoa;

console.log(nm);




//-------------------------------------------------------------------------------------------------------------------




//SPREAD operator (...)
console.log("2. Exercicio de operadores SPREAD");

let nomes1 = ["João", "Ana"];

//Modo antigo:
let nomes2 = ["Bia", "Carlos"].concat(nomes1);
console.log(nomes2);
//Modo Novo de espalhamento ou concatenação:
let nomes3 = ["Bia", "Carlos", ...nomes1];
console.log(nomes3);

//Criando um array de caracteres a partir de uma string:
let fraseee = "Esta é a minha frase";

//Modo antigo:
let caract = fraseee.split("");
console.log(caract);
//Modo Novo de espalhamento ou concatenação:
let caracteres = [...fraseee];
console.log(caracteres);

//spread como parametros de funções.
let dat = [10,20,30];
function adicao(x, y, z){
    return x + y + z;
}
let result = adicao(...dat);
console.log(result);




//-------------------------------------------------------------------------------------------------------------------



//Template Literals
console.log("3. Exercicio de Template literals");

let person = {
    name: "Renato Rodrigues"
};

let automovel = {
    marca: "Audi",
    ano: 2018
};

//Modo antigo de concatenação
let frase = "Olá, sr. " + person.name + ". O " + automovel.marca + " de " + automovel.ano + " é seu neste momento!.";
console.log(frase);
//NOVO Modo de concatenação "Template literals"
let frase2 = `Olá, sr. ${person.name}. O ${automovel.marca} de ${automovel.ano} é seu neste momento!.`;
console.log(frase2);



//-------------------------------------------------------------------------------------------------------------------



//Classes
console.log("4. Exercicio de Classes em javascript");

class Pessoa {
    constructor(n, i){
        this.nome = n;
        this.idade = i;
    }
    falar(texto){
        console.log(texto)
    }
    adicionar(x, y){
        console.log(x + y);
        //return x + y;
    }
}

let eu = new Pessoa('Renato', 24);

console.log(eu.nome);
eu.falar("Olá a todos");
eu.adicionar(10, 20);

//Heranças em Javascript
class Veiculo{
    constructor(tipo){
        this.tipo = tipo;
    }
    identificar(){
        return "Eu sou um " + this.tipo;
    }
}

class Automovel extends Veiculo{
    mudarCaixaVelocidade(){
        return "Alterei para a marcha-ré";
    }
}
class Aviao extends Veiculo{
    definirAutitude(valor){
        //logica
        valor++;
    }
}

let auto = new Automovel('Carro');
let plane = new Aviao('Aeroplano');

console.log(auto.identificar());


//Gets e Sets
class Humano{
    constructor(nome, idade){
        this._nome = nome;
        this._idade = idade;
    }
    get Nome(){return this._nome;}
    get Idade(){return this._idade;}

    set Nome(valor){this._nome = valor;}
    set Idade(valor){this._idade = valor;}
}

let homem = new Humano("Sujeito", 18);
homem.Nome = "Renato";
console.log(homem.Nome);



//-------------------------------------------------------------------------------------------------------------------



//Arrow Functions
console.log("5. Exercicio de conversão de funções em Arrow Functions");

//Modo antigo de escrita de função
var soma = function(num1, num2){
    return num1 + num2;
};
//Novo modo de escrita Arrow Functions
var soma2 = (num1, num2) => {
    return num1 + num2;
}
//Ou menor ainda...
var soma3 = (num1, num2) => num1 + num2;

//resultado
console.log(soma3(1, 3));

//Outro exemplo =========================================================
var contaPalavras = function(fras){
    return fras.split(' ').length;
}
//Com arrow
var contaPalavras2 = (fras) => {
    return fras.split(' ').length;
}
//menor ainda
var contaPalavras3 = fras => fras.split(' ').length;

console.log(contaPalavras3("Renato Rodrigues da Costa"));


//Outro exemplo *Sem parametros* =======================================
var mostraSegundos = function(){
    return new Date().getMilliseconds();
}
//Com arrow
var mostraSegundos2 = () => new Date().getSeconds();

console.log(mostraSegundos2());

//Outro exemplo *Retornando objeto literal* ===========================
var objetoUser = function(id, nome){
    return {
        id: id,
        nome: nome
    };
};
//Com arrow function
var objetoUser2 = (id, nome) => ({id: id, nome: nome});

console.log(objetoUser2(1234, "Renato"));

//Outro exemplo *com reduce* ==========================================
var itemsCarrinho = [
    { id: 1, nome: 'item 1', preco: 1200 },
    { id: 2, nome: 'item 2', preco: 2500 },
];

var total = itemsCarrinho.reduce(function(total, item){
    return total + item.preco;
}, 0);

//Com arrow function
var total2 = itemsCarrinho.reduce((total, item) => total + item.preco, 0);

console.log(total2);