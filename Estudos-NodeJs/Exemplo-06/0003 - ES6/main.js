//Metodos estaticos --------------------------------------------------------------

class Matematica{
    static soma(a, b) {
        return a + b;
    }
}

console.log(Matematica.soma(10, 20));

//Classes e métodos com herença --------------------------------------------------------------
class List{
    constructor(){
        this.data = [];
    }
    add(data){
        this.data.push(data);
        console.log(this.data);
    }
}

class TodoList extends List{
    constructor(){
        super();
        this.usuario = 'Renato';
    }
    mostraUsuario(){
        console.log(this.usuario);
    }
}

const MinhaLista = new TodoList();

document.getElementById('novotodo').onclick = function(){
    MinhaLista.add('Novo todo');
}

MinhaLista.mostraUsuario();

//Operações em vetores com ES6 --------------------------------------------------------------

const arr = [1,2,3,4,5,6,7,8];

const newArr = arr.map(function(item, index){
    return "(" + index + "): " + item * 2;

});

console.log(newArr);

//-------------------------------

const sum = arr.reduce(function(total, next){
    return total + next;
});

console.log(sum);

//-------------------------------

const filter = arr.filter(function(item){
    return item % 2 === 0;
});

console.log(filter);

//-------------------------------

const find = arr.find(function(item){
    return item === 4;
});

console.log(find);

//Arrow functions --------------------------------------------------------------

const arreyArrow = [1,2,3,4,5,6,7,8];

const newArow = arreyArrow.map((item) => {
    return item * 2;
});

console.log(newArow);

//Valores padrão

const multiplica = (a = 3, b = 6) => a * b;

console.log(multiplica());

//Desestruturação de objetos --------------------------------------------------------------

const user = {
    nome: 'Renato',
    idade: 24,
    endereco: {
        cidade: 'Praia Grande - SP',
        bairro: 'Jardim Melvi',
        estado: 'SP'
    }
}

console.log(user);

//const nome = user.nome;
const { nome, idade} = user;
console.log(nome);

//REST E SPREAD --------------------------------------------------------------

//rest
const usuariooo = {
    name: 'Renato Rodrigues',
    idade: 24,
    empresa: 'Rocket'
}

const { name, ...resto } = usuariooo;
console.log(nome);
console.log(resto);

//spread
const arr1 = [1,2,3];
const arr2 = [4,5,6,7,8];

const arr3 = [...arr1, ...arr2];
console.log(arr3);

//Template literals ---------------------------------------------------------

const credential = 'Renato Rodrigues da Costa';
const age = 24;

// console.log('Meu nome é ' + credential + ' e tenho ' + age + ' anos');
console.log(`Meu nome é ${credential} e tenho ${age} anos!.`);


//=================================================== Exercicios =======================================================

//Exercicio 01:

// Para testar seus conhecimentos com classes, crie uma classe com nome "Admin", essa classe deve
// extender uma segunda classe chamada "Usuario".
// A classe usuário deve receber dois parâmetros no método construtor, e-mail e senha, e anotá-los
// em propriedades da classe. A classe "Admin" por sua vez não recebe parâmetros mas deve
// repassar os parâmetros de e-mail e senha à classe pai e marcar uma propriedade "admin" como
// true na classe.
// Agora com suas classes formatadas, adicione um método na classe Usuario chamado isAdmin que
// retorna se o usuário é administrador ou não baseado na propriedade admin ser true ou não.

class UsuarioPadrao{
    constructor(email, senha){
        this.email = email;
        this.senha = senha;
        this.adm = false;
    }
    isAdmin(){
        if(this.adm == true)
            return 'Administrador!';
        else
            return 'Usuário padrão!';
    }
}

class Admin extends UsuarioPadrao{
    constructor(){
        super();
        this.adm = true;
    }
}

const user1 = new UsuarioPadrao('teste@teste.com', 'senha123');
const user2 = new UsuarioPadrao('teste@teste.com', 'senha123');
const adm1 = new Admin('teste@teste.com', 'senha123');

console.log(user1.isAdmin()); //deve retornar falso por que a classe chamada foi "UsuarioPadrão"
console.log(user2.isAdmin()); //deve retornar falso por que a classe chamada foi "UsuarioPadrão"
console.log(adm1.isAdmin()); //deve retornar true por que a classe chamada foi "Admin"

//Exercicio 02:

//2.1
const users = [
    { nm: 'Diego', idad: 23, empresa: 'Rocketseat' },
    { nm: 'Gabriel', idad: 15, empresa: 'Rocketseat' },
    { nm: 'Lucas', idad: 30, empresa: 'Facebook' },
   ];

   const ex = users.map(function(item){
    return {} = item.idad;
});
console.log(ex);
// const idades = users.map(usuario => usuario.idade);
// console.log(idades);

//2.2
    const ex2 = users.filter(function(item){
    return {} = item.idad > 18 && item.empresa === 'Rocketseat';
});
console.log(ex2);
// const rocketseat18 = users.filter(
//     usuario => usuario.empresa === "Rocketseat" && usuario.idade >= 18
//   );
// console.log(rocketseat18);

//2.3
    const ex3 = users.find(function(item){
    return item.empresa === 'Google';
});
console.log(ex3);
// const google = users.find(usuario => usuario.empresa === "Google");
// console.log(google);

//2.4
    const ex4 = users.filter(function(item){
    return {} = (item.idad * 2) <= 50;
});
console.log(ex4);
// const calculo = users
//   .map(usuario => ({ ...usuario, idade: usuario.idade * 2 }))
//   .filter(usuario => usuario.idade <= 50);

// console.log(calculo);


//Exercicio 03:

// Converta as funções nos seguintes trechos de código em Arrow Functions:

// 3.1
const arra = [1, 2, 3, 4, 5];
// arra.map(function(item) {
//  return item + 10;
// });
   arra.map(item => item + 10);

// 3.2
// Dica: Utilize uma constante pra function
   const us = { n: 'Diego', i: 23 };
// function mostraIdade(us) {
//  return us.i;
// }
   const mostraIdad = us => us.i;
   mostraIdad(us);

// 3.3
// Dica: Utilize uma constante pra function
//    const noome = "Diego";
//    const idade = 23;
// function mostraUs(noome = 'Diego', idaaade = 18) {
//  return { noome, idaaade };
// }
    // const mostraUs = (noome = "Diego", idaade = 18) => ({
    //     noome,
    //     idaade
    // });
// mostraUs(noome, idaade);
// mostraUs(noome);

// 3.4
// const promise = function() {
//  return new Promise(function(resolve, reject) {
//  return resolve();
//  })
// }

// const promise = () => new Promise((resolve, reject) => resolve());

//Exercicio 04:

const negocio = {
    ds: 'Rocketseat',
    endereco: {
        cit: 'Rio do Sul',
        df: 'SC',
    }
};
   
const {ds, endereco: {cit, df} } = negocio;

console.log(ds); // Rocketseat
console.log(cit); // Rio do Sul
console.log(df); // SC




   






