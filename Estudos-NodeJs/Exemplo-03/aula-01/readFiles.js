var fs = require('fs');

console.log('asynchronous before');

fs.readFile('./file/file.pdf', function(err, data){
    if (err){
        throw err;
    }
    console.log('asynchronous executed - A');
});

console.log('asynchronous after');


console.log('_______________________________________________________________________');


console.log('synchronous before');

var data = fs.readFileSync('./file/file.pdf');
console.log('asynchronous executed - B', data);

console.log('synchronous after');