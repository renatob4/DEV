module.exports = function(io){
    io.sockets.on('connection', function(client){
        client.emit('hello', {title: 'Bem vindo', msg: 'Você esta conectado!'});
        client.broadcast.emit('hello', {title: 'Nova conexão', msg: 'Alguém se conectou!'});

        client.on('add', function(data){
            client.broadcast.emit('add_response', {title: 'Nova tarefa', msg: 'Uma nova tarefa foi adicionada.'});
        });

        client.on('turn', function(data){
            var msg = {
                title: 'Tarefa concluida',
                msg: 'Alguem acha que não terminou uma tarefa!.'
            };
            if(!data){
                msg = {
                    title: 'Tarefa desfeita',
                    msg: 'Alguem acha que não terminou uma tarefa!.'
                };
            }
            client.broadcast.emit('turn_response', msg);
        });
    });

    
}