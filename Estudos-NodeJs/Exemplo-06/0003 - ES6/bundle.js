"use strict";

function _objectDestructuringEmpty(obj) { if (obj == null) throw new TypeError("Cannot destructure undefined"); }

function _objectWithoutProperties(source, excluded) { if (source == null) return {}; var target = _objectWithoutPropertiesLoose(source, excluded); var key, i; if (Object.getOwnPropertySymbols) { var sourceSymbolKeys = Object.getOwnPropertySymbols(source); for (i = 0; i < sourceSymbolKeys.length; i++) { key = sourceSymbolKeys[i]; if (excluded.indexOf(key) >= 0) continue; if (!Object.prototype.propertyIsEnumerable.call(source, key)) continue; target[key] = source[key]; } } return target; }

function _objectWithoutPropertiesLoose(source, excluded) { if (source == null) return {}; var target = {}; var sourceKeys = Object.keys(source); var key, i; for (i = 0; i < sourceKeys.length; i++) { key = sourceKeys[i]; if (excluded.indexOf(key) >= 0) continue; target[key] = source[key]; } return target; }

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

//Metodos estaticos --------------------------------------------------------------
var Matematica =
/*#__PURE__*/
function () {
  function Matematica() {
    _classCallCheck(this, Matematica);
  }

  _createClass(Matematica, null, [{
    key: "soma",
    value: function soma(a, b) {
      return a + b;
    }
  }]);

  return Matematica;
}();

console.log(Matematica.soma(10, 20)); //Classes e métodos com herença --------------------------------------------------------------

var List =
/*#__PURE__*/
function () {
  function List() {
    _classCallCheck(this, List);

    this.data = [];
  }

  _createClass(List, [{
    key: "add",
    value: function add(data) {
      this.data.push(data);
      console.log(this.data);
    }
  }]);

  return List;
}();

var TodoList =
/*#__PURE__*/
function (_List) {
  _inherits(TodoList, _List);

  function TodoList() {
    var _this;

    _classCallCheck(this, TodoList);

    _this = _possibleConstructorReturn(this, _getPrototypeOf(TodoList).call(this));
    _this.usuario = 'Renato';
    return _this;
  }

  _createClass(TodoList, [{
    key: "mostraUsuario",
    value: function mostraUsuario() {
      console.log(this.usuario);
    }
  }]);

  return TodoList;
}(List);

var MinhaLista = new TodoList();

document.getElementById('novotodo').onclick = function () {
  MinhaLista.add('Novo todo');
};

MinhaLista.mostraUsuario(); //Operações em vetores com ES6 --------------------------------------------------------------

var arr = [1, 2, 3, 4, 5, 6, 7, 8];
var newArr = arr.map(function (item, index) {
  return "(" + index + "): " + item * 2;
});
console.log(newArr); //-------------------------------

var sum = arr.reduce(function (total, next) {
  return total + next;
});
console.log(sum); //-------------------------------

var filter = arr.filter(function (item) {
  return item % 2 === 0;
});
console.log(filter); //-------------------------------

var find = arr.find(function (item) {
  return item === 4;
});
console.log(find); //Arrow functions --------------------------------------------------------------

var arreyArrow = [1, 2, 3, 4, 5, 6, 7, 8];
var newArow = arreyArrow.map(function (item) {
  return item * 2;
});
console.log(newArow); //Valores padrão

var multiplica = function multiplica() {
  var a = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 3;
  var b = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 6;
  return a * b;
};

console.log(multiplica()); //Desestruturação de objetos --------------------------------------------------------------

var user = {
  nome: 'Renato',
  idade: 24,
  endereco: {
    cidade: 'Praia Grande - SP',
    bairro: 'Jardim Melvi',
    estado: 'SP'
  }
};
console.log(user); //const nome = user.nome;

var nome = user.nome,
    idade = user.idade;
console.log(nome); //REST E SPREAD --------------------------------------------------------------
//rest

var usuariooo = {
  name: 'Renato Rodrigues',
  idade: 24,
  empresa: 'Rocket'
};

var name = usuariooo.name,
    resto = _objectWithoutProperties(usuariooo, ["name"]);

console.log(nome);
console.log(resto); //spread

var arr1 = [1, 2, 3];
var arr2 = [4, 5, 6, 7, 8];
var arr3 = arr1.concat(arr2);
console.log(arr3); //Template literals ---------------------------------------------------------

var credential = 'Renato Rodrigues da Costa';
var age = 24; // console.log('Meu nome é ' + credential + ' e tenho ' + age + ' anos');

console.log("Meu nome \xE9 ".concat(credential, " e tenho ").concat(age, " anos!.")); //=================================================== Exercicios =======================================================
//Exercicio 01:
// Para testar seus conhecimentos com classes, crie uma classe com nome "Admin", essa classe deve
// extender uma segunda classe chamada "Usuario".
// A classe usuário deve receber dois parâmetros no método construtor, e-mail e senha, e anotá-los
// em propriedades da classe. A classe "Admin" por sua vez não recebe parâmetros mas deve
// repassar os parâmetros de e-mail e senha à classe pai e marcar uma propriedade "admin" como
// true na classe.
// Agora com suas classes formatadas, adicione um método na classe Usuario chamado isAdmin que
// retorna se o usuário é administrador ou não baseado na propriedade admin ser true ou não.

var UsuarioPadrao =
/*#__PURE__*/
function () {
  function UsuarioPadrao(email, senha) {
    _classCallCheck(this, UsuarioPadrao);

    this.email = email;
    this.senha = senha;
    this.adm = false;
  }

  _createClass(UsuarioPadrao, [{
    key: "isAdmin",
    value: function isAdmin() {
      if (this.adm == true) return 'Administrador!';else return 'Usuário padrão!';
    }
  }]);

  return UsuarioPadrao;
}();

var Admin =
/*#__PURE__*/
function (_UsuarioPadrao) {
  _inherits(Admin, _UsuarioPadrao);

  function Admin() {
    var _this2;

    _classCallCheck(this, Admin);

    _this2 = _possibleConstructorReturn(this, _getPrototypeOf(Admin).call(this));
    _this2.adm = true;
    return _this2;
  }

  return Admin;
}(UsuarioPadrao);

var user1 = new UsuarioPadrao('teste@teste.com', 'senha123');
var user2 = new UsuarioPadrao('teste@teste.com', 'senha123');
var adm1 = new Admin('teste@teste.com', 'senha123');
console.log(user1.isAdmin()); //deve retornar falso por que a classe chamada foi "UsuarioPadrão"

console.log(user2.isAdmin()); //deve retornar falso por que a classe chamada foi "UsuarioPadrão"

console.log(adm1.isAdmin()); //deve retornar true por que a classe chamada foi "Admin"
//Exercicio 02:
//2.1

var users = [{
  nm: 'Diego',
  idad: 23,
  empresa: 'Rocketseat'
}, {
  nm: 'Gabriel',
  idad: 15,
  empresa: 'Rocketseat'
}, {
  nm: 'Lucas',
  idad: 30,
  empresa: 'Facebook'
}];
var ex = users.map(function (item) {
  var _item$idad;

  return _item$idad = item.idad, _objectDestructuringEmpty(_item$idad), _item$idad;
});
console.log(ex); // const idades = users.map(usuario => usuario.idade);
// console.log(idades);
//2.2

var ex2 = users.filter(function (item) {
  var _ref;

  return _ref = item.idad > 18 && item.empresa === 'Rocketseat', _objectDestructuringEmpty(_ref), _ref;
});
console.log(ex2); // const rocketseat18 = users.filter(
//     usuario => usuario.empresa === "Rocketseat" && usuario.idade >= 18
//   );
// console.log(rocketseat18);
//2.3

var ex3 = users.find(function (item) {
  return item.empresa === 'Google';
});
console.log(ex3); // const google = users.find(usuario => usuario.empresa === "Google");
// console.log(google);
//2.4

var ex4 = users.filter(function (item) {
  var _ref2;

  return _ref2 = item.idad * 2 <= 50, _objectDestructuringEmpty(_ref2), _ref2;
});
console.log(ex4); // const calculo = users
//   .map(usuario => ({ ...usuario, idade: usuario.idade * 2 }))
//   .filter(usuario => usuario.idade <= 50);
// console.log(calculo);
//Exercicio 03:
// Converta as funções nos seguintes trechos de código em Arrow Functions:
// 3.1

var arra = [1, 2, 3, 4, 5]; // arra.map(function(item) {
//  return item + 10;
// });

arra.map(function (item) {
  return item + 10;
}); // 3.2
// Dica: Utilize uma constante pra function

var us = {
  n: 'Diego',
  i: 23
}; // function mostraIdade(us) {
//  return us.i;
// }

var mostraIdad = function mostraIdad(us) {
  return us.i;
};

mostraIdad(us); // 3.3
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

var negocio = {
  ds: 'Rocketseat',
  endereco: {
    cit: 'Rio do Sul',
    df: 'SC'
  }
};
var ds = negocio.ds,
    _negocio$endereco = negocio.endereco,
    cit = _negocio$endereco.cit,
    df = _negocio$endereco.df;
console.log(ds); // Rocketseat

console.log(cit); // Rio do Sul

console.log(df); // SC
