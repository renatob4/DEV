/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./main.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./funcoes.js":
/*!********************!*\
  !*** ./funcoes.js ***!
  \********************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
eval("\n\nObject.defineProperty(exports, \"__esModule\", {\n  value: true\n});\nexports.sub = sub;\nexports.mult = mult;\nexports.div = div;\n\n//exportando funçoes que podem ser recebidas em main.js\nfunction sub(a, b) {\n  return a - b;\n}\n\nfunction mult(a, b) {\n  return a * b;\n}\n\nfunction div(a, b) {\n  return a / b;\n}\n\n//# sourceURL=webpack:///./funcoes.js?");

/***/ }),

/***/ "./main.js":
/*!*****************!*\
  !*** ./main.js ***!
  \*****************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
eval("\n\nvar funcoes = _interopRequireWildcard(__webpack_require__(/*! ./funcoes */ \"./funcoes.js\"));\n\nvar _soma = _interopRequireDefault(__webpack_require__(/*! ./soma */ \"./soma.js\"));\n\nfunction _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }\n\nfunction _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) { var desc = Object.defineProperty && Object.getOwnPropertyDescriptor ? Object.getOwnPropertyDescriptor(obj, key) : {}; if (desc.get || desc.set) { Object.defineProperty(newObj, key, desc); } else { newObj[key] = obj[key]; } } } } newObj.default = obj; return newObj; } }\n\nfunction _objectDestructuringEmpty(obj) { if (obj == null) throw new TypeError(\"Cannot destructure undefined\"); }\n\nfunction _objectWithoutProperties(source, excluded) { if (source == null) return {}; var target = _objectWithoutPropertiesLoose(source, excluded); var key, i; if (Object.getOwnPropertySymbols) { var sourceSymbolKeys = Object.getOwnPropertySymbols(source); for (i = 0; i < sourceSymbolKeys.length; i++) { key = sourceSymbolKeys[i]; if (excluded.indexOf(key) >= 0) continue; if (!Object.prototype.propertyIsEnumerable.call(source, key)) continue; target[key] = source[key]; } } return target; }\n\nfunction _objectWithoutPropertiesLoose(source, excluded) { if (source == null) return {}; var target = {}; var sourceKeys = Object.keys(source); var key, i; for (i = 0; i < sourceKeys.length; i++) { key = sourceKeys[i]; if (excluded.indexOf(key) >= 0) continue; target[key] = source[key]; } return target; }\n\nfunction _typeof(obj) { if (typeof Symbol === \"function\" && typeof Symbol.iterator === \"symbol\") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === \"function\" && obj.constructor === Symbol && obj !== Symbol.prototype ? \"symbol\" : typeof obj; }; } return _typeof(obj); }\n\nfunction _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === \"object\" || typeof call === \"function\")) { return call; } return _assertThisInitialized(self); }\n\nfunction _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError(\"this hasn't been initialised - super() hasn't been called\"); } return self; }\n\nfunction _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }\n\nfunction _inherits(subClass, superClass) { if (typeof superClass !== \"function\" && superClass !== null) { throw new TypeError(\"Super expression must either be null or a function\"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }\n\nfunction _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }\n\nfunction _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError(\"Cannot call a class as a function\"); } }\n\nfunction _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if (\"value\" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }\n\nfunction _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }\n\nconsole.log((0, funcoes.sub)(3, 2)); //importando funções DEFAULT\n\nconsole.log((0, _soma.default)(1, 2)); //importando varias funçoes de uma vez com um array de objetos\n\nconsole.log(funcoes.div(10, 2)); //Metodos estaticos --------------------------------------------------------------\n\nvar Matematica =\n/*#__PURE__*/\nfunction () {\n  function Matematica() {\n    _classCallCheck(this, Matematica);\n  }\n\n  _createClass(Matematica, null, [{\n    key: \"soma\",\n    value: function soma(a, b) {\n      return a + b;\n    }\n  }]);\n\n  return Matematica;\n}();\n\nconsole.log(Matematica.soma(10, 20)); //Classes e métodos com herença --------------------------------------------------------------\n\nvar List =\n/*#__PURE__*/\nfunction () {\n  function List() {\n    _classCallCheck(this, List);\n\n    this.data = [];\n  }\n\n  _createClass(List, [{\n    key: \"add\",\n    value: function add(data) {\n      this.data.push(data);\n      console.log(this.data);\n    }\n  }]);\n\n  return List;\n}();\n\nvar TodoList =\n/*#__PURE__*/\nfunction (_List) {\n  _inherits(TodoList, _List);\n\n  function TodoList() {\n    var _this;\n\n    _classCallCheck(this, TodoList);\n\n    _this = _possibleConstructorReturn(this, _getPrototypeOf(TodoList).call(this));\n    _this.usuario = 'Renato';\n    return _this;\n  }\n\n  _createClass(TodoList, [{\n    key: \"mostraUsuario\",\n    value: function mostraUsuario() {\n      console.log(this.usuario);\n    }\n  }]);\n\n  return TodoList;\n}(List);\n\nvar MinhaLista = new TodoList();\n\ndocument.getElementById('novotodo').onclick = function () {\n  MinhaLista.add('Novo todo');\n};\n\nMinhaLista.mostraUsuario(); //Operações em vetores com ES6 --------------------------------------------------------------\n\nvar arr = [1, 2, 3, 4, 5, 6, 7, 8];\nvar newArr = arr.map(function (item, index) {\n  return \"(\" + index + \"): \" + item * 2;\n});\nconsole.log(newArr); //-------------------------------\n\nvar sum = arr.reduce(function (total, next) {\n  return total + next;\n});\nconsole.log(sum); //-------------------------------\n\nvar filter = arr.filter(function (item) {\n  return item % 2 === 0;\n});\nconsole.log(filter); //-------------------------------\n\nvar find = arr.find(function (item) {\n  return item === 4;\n});\nconsole.log(find); //Arrow functions --------------------------------------------------------------\n\nvar arreyArrow = [1, 2, 3, 4, 5, 6, 7, 8];\nvar newArow = arreyArrow.map(function (item) {\n  return item * 2;\n});\nconsole.log(newArow); //Valores padrão\n\nvar multiplica = function multiplica() {\n  var a = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 3;\n  var b = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 6;\n  return a * b;\n};\n\nconsole.log(multiplica()); //Desestruturação de objetos --------------------------------------------------------------\n\nvar user = {\n  nome: 'Renato',\n  idade: 24,\n  endereco: {\n    cidade: 'Praia Grande - SP',\n    bairro: 'Jardim Melvi',\n    estado: 'SP'\n  }\n};\nconsole.log(user); //const nome = user.nome;\n\nvar nome = user.nome,\n    idade = user.idade;\nconsole.log(nome); //REST E SPREAD --------------------------------------------------------------\n//rest\n\nvar usuariooo = {\n  name: 'Renato Rodrigues',\n  idade: 24,\n  empresa: 'Rocket'\n};\n\nvar name = usuariooo.name,\n    resto = _objectWithoutProperties(usuariooo, [\"name\"]);\n\nconsole.log(nome);\nconsole.log(resto); //spread\n\nvar arr1 = [1, 2, 3];\nvar arr2 = [4, 5, 6, 7, 8];\nvar arr3 = arr1.concat(arr2);\nconsole.log(arr3); //Template literals ---------------------------------------------------------\n\nvar credential = 'Renato Rodrigues da Costa';\nvar age = 24; // console.log('Meu nome é ' + credential + ' e tenho ' + age + ' anos');\n\nconsole.log(\"Meu nome \\xE9 \".concat(credential, \" e tenho \").concat(age, \" anos!.\")); //=================================================== Exercicios =======================================================\n//Exercicio 01:\n// Para testar seus conhecimentos com classes, crie uma classe com nome \"Admin\", essa classe deve\n// extender uma segunda classe chamada \"Usuario\".\n// A classe usuário deve receber dois parâmetros no método construtor, e-mail e senha, e anotá-los\n// em propriedades da classe. A classe \"Admin\" por sua vez não recebe parâmetros mas deve\n// repassar os parâmetros de e-mail e senha à classe pai e marcar uma propriedade \"admin\" como\n// true na classe.\n// Agora com suas classes formatadas, adicione um método na classe Usuario chamado isAdmin que\n// retorna se o usuário é administrador ou não baseado na propriedade admin ser true ou não.\n\nvar UsuarioPadrao =\n/*#__PURE__*/\nfunction () {\n  function UsuarioPadrao(email, senha) {\n    _classCallCheck(this, UsuarioPadrao);\n\n    this.email = email;\n    this.senha = senha;\n    this.adm = false;\n  }\n\n  _createClass(UsuarioPadrao, [{\n    key: \"isAdmin\",\n    value: function isAdmin() {\n      if (this.adm == true) return 'Administrador!';else return 'Usuário padrão!';\n    }\n  }]);\n\n  return UsuarioPadrao;\n}();\n\nvar Admin =\n/*#__PURE__*/\nfunction (_UsuarioPadrao) {\n  _inherits(Admin, _UsuarioPadrao);\n\n  function Admin() {\n    var _this2;\n\n    _classCallCheck(this, Admin);\n\n    _this2 = _possibleConstructorReturn(this, _getPrototypeOf(Admin).call(this));\n    _this2.adm = true;\n    return _this2;\n  }\n\n  return Admin;\n}(UsuarioPadrao);\n\nvar user1 = new UsuarioPadrao('teste@teste.com', 'senha123');\nvar user2 = new UsuarioPadrao('teste@teste.com', 'senha123');\nvar adm1 = new Admin('teste@teste.com', 'senha123');\nconsole.log(user1.isAdmin()); //deve retornar falso por que a classe chamada foi \"UsuarioPadrão\"\n\nconsole.log(user2.isAdmin()); //deve retornar falso por que a classe chamada foi \"UsuarioPadrão\"\n\nconsole.log(adm1.isAdmin()); //deve retornar true por que a classe chamada foi \"Admin\"\n//Exercicio 02:\n//2.1\n\nvar users = [{\n  nm: 'Diego',\n  idad: 23,\n  empresa: 'Rocketseat'\n}, {\n  nm: 'Gabriel',\n  idad: 15,\n  empresa: 'Rocketseat'\n}, {\n  nm: 'Lucas',\n  idad: 30,\n  empresa: 'Facebook'\n}];\nvar ex = users.map(function (item) {\n  var _item$idad;\n\n  return _item$idad = item.idad, _objectDestructuringEmpty(_item$idad), _item$idad;\n});\nconsole.log(ex); // const idades = users.map(usuario => usuario.idade);\n// console.log(idades);\n//2.2\n\nvar ex2 = users.filter(function (item) {\n  var _ref;\n\n  return _ref = item.idad > 18 && item.empresa === 'Rocketseat', _objectDestructuringEmpty(_ref), _ref;\n});\nconsole.log(ex2); // const rocketseat18 = users.filter(\n//     usuario => usuario.empresa === \"Rocketseat\" && usuario.idade >= 18\n//   );\n// console.log(rocketseat18);\n//2.3\n\nvar ex3 = users.find(function (item) {\n  return item.empresa === 'Google';\n});\nconsole.log(ex3); // const google = users.find(usuario => usuario.empresa === \"Google\");\n// console.log(google);\n//2.4\n\nvar ex4 = users.filter(function (item) {\n  var _ref2;\n\n  return _ref2 = item.idad * 2 <= 50, _objectDestructuringEmpty(_ref2), _ref2;\n});\nconsole.log(ex4); // const calculo = users\n//   .map(usuario => ({ ...usuario, idade: usuario.idade * 2 }))\n//   .filter(usuario => usuario.idade <= 50);\n// console.log(calculo);\n//Exercicio 03:\n// Converta as funções nos seguintes trechos de código em Arrow Functions:\n// 3.1\n\nvar arra = [1, 2, 3, 4, 5]; // arra.map(function(item) {\n//  return item + 10;\n// });\n\narra.map(function (item) {\n  return item + 10;\n}); // 3.2\n// Dica: Utilize uma constante pra function\n\nvar us = {\n  n: 'Diego',\n  i: 23\n}; // function mostraIdade(us) {\n//  return us.i;\n// }\n\nvar mostraIdad = function mostraIdad(us) {\n  return us.i;\n};\n\nmostraIdad(us); // 3.3\n// Dica: Utilize uma constante pra function\n//    const noome = \"Diego\";\n//    const idade = 23;\n// function mostraUs(noome = 'Diego', idaaade = 18) {\n//  return { noome, idaaade };\n// }\n// const mostraUs = (noome = \"Diego\", idaade = 18) => ({\n//     noome,\n//     idaade\n// });\n// mostraUs(noome, idaade);\n// mostraUs(noome);\n// 3.4\n// const promise = function() {\n//  return new Promise(function(resolve, reject) {\n//  return resolve();\n//  })\n// }\n// const promise = () => new Promise((resolve, reject) => resolve());\n//Exercicio 04:\n\nvar negocio = {\n  ds: 'Rocketseat',\n  endereco: {\n    cit: 'Rio do Sul',\n    df: 'SC'\n  }\n};\nvar ds = negocio.ds,\n    _negocio$endereco = negocio.endereco,\n    cit = _negocio$endereco.cit,\n    df = _negocio$endereco.df;\nconsole.log(ds); // Rocketseat\n\nconsole.log(cit); // Rio do Sul\n\nconsole.log(df); // SC\n\n//# sourceURL=webpack:///./main.js?");

/***/ }),

/***/ "./soma.js":
/*!*****************!*\
  !*** ./soma.js ***!
  \*****************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
eval("\n\nObject.defineProperty(exports, \"__esModule\", {\n  value: true\n});\nexports.default = soma;\n\n//Declaração de função DEFAULT\nfunction soma(a, b) {\n  return a + b;\n}\n\n//# sourceURL=webpack:///./soma.js?");

/***/ })

/******/ });