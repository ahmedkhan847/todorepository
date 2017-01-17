<?php
require 'vendor/autoload.php';
include 'config.php';

$app = new Slim\App(['settings' => $config]);

// dependencies
$container = $app->getContainer();
$container['db'] = function($c) {
    $settings = $c['settings']['db'];
    $db = new TodoRepository\Db\Connection($settings);
    return $db;
};

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
    ->withHeader('Access-Control-Allow-Origin', '*')
    ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

$app->get('/todo/', function($request,$response) {
    
    $todo = new TodoRepository\Todo();
    $data = null;
    $offset = 0;
    $limit = 0;
    $result = $todo->getAllTodo();
    while ($row = $result->fetch_assoc()){
        
        $data[] = $row;
    }
    
    $result =  $data;
    $response->withStatus(200)->write(json_encode($result));
    
});

$app->get('/todo/{id}/', function($request,$response) {
    
    $id = $request->getAttribute('id');
    $todo = new TodoRepository\Todo();
    $data = null;
    $result = $todo->getTodo($id);
    $data[] = $result->fetch_assoc();
    $response->withStatus(200)->write(json_encode($data));
    
});

$app->post('/todo/', function($request,$response){
    
    
    $todos = $request->getParam('todo');
    $cat = $request->getParam('cat');
    $desc = $request->getParam('desc');
    
    $todo = new TodoRepository\Todo();
    
    $result = $todo->createtodo($todos, $cat, $desc);
    
    if($result === true){
        return $response->withStatus(200)->write("inserted");
    }
    else{
        return $response->withStatus(422)->write(json_encode($result));
    }
    
});

$app->delete('/todo/{id}/', function($request,$response){
    
    $todo = new TodoRepository\Todo();
    $id = $request->getAttribute('id');
    $result = $todo->delTodo($id);
    if($result === true){
        return $response->withStatus(200)->write("deleted");
    }
    else{
        return $response->withStatus(422)->write($result);
    }
    
});

$app->put('/todo/{id}/', function($request,$response){
    
    $todo = new TodoRepository\Todo();
    $id = $request->getAttribute('id');
    $todos = $request->getParam('todo');
    $cat = $request->getParam('cat');
    $desc = $request->getParam('desc');
    $result = $todo->updateTodo($todos, $cat, $desc, $id);
    if($result === true){
        return $response->withStatus(200)->write("updated");
    }
    else{
        return $response->withStatus(422)->write($result);
    }
    
});

$app->run();