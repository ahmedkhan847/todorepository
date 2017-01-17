<?php
require 'vendor/autoload.php';

require 'config.php';

$app = new Slim\App(['settings' => $config]);

// dependencies
$container = $app->getContainer();
$container['db'] = function($c) {
    $settings = $c['settings']['db'];
    $db = new TodoRepository\Api\Db\Connection($settings);
    return $db;
};

// routes
$app->options('/{routes:.+}',
function ($request, $response, $args) {
    return $response;
}
);

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
    ->withHeader('Access-Control-Allow-Origin', '*')
    ->withHeader('Access-Control-Allow-Headers',
    'X-Requested-With, Content-Type, Accept, Origin, Authorization')
    ->withHeader('Access-Control-Allow-Methods',
    'GET, POST, PUT, DELETE, OPTIONS');
});

$app->get('/todo/', function ($request, $response)
use ($container) {
    $todo   = new \TodoRepository\Api\Todo($container['db']);
    $data   = NULL;
    $result = $todo->getAllTodo();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    
    $result = $data;
    $response->withStatus(200)->write(json_encode($result));
});

$app->get('/todo/{id}/', function ($request, $response)
use ($container) {
    $id     = $request->getAttribute('id');
    $todo   = new \TodoRepository\Api\Todo($container['db']);
    $data   = NULL;
    $data[] = $todo->getTodo($id);
    $response->withStatus(200)->write(json_encode($data));
});

$app->post('/todo/', function ($request, $response)
use ($container) {
    $todo = new TodoRepository\Api\Todo($container['db']);
    $todos  = $request->getParam('todo');
    $cat    = $request->getParam('cat');
    $desc   = $request->getParam('desc');
    $result = $todo->createtodo($todos, $cat, $desc);
    
    if ($result === TRUE) {
        return $response->withStatus(200)->write('inserted');
    } else {
        return $response->withStatus(422)->write(json_encode($result));
    }
});

$app->delete('/todo/{id}/', function ($request, $response) 
use ($container) {
    $todo   = new TodoRepository\Api\Todo($container['db']);
    $id     = $request->getAttribute('id');
    $result = $todo->delTodo($id);
    if ($result === TRUE) {
        return $response->withStatus(200)->write("deleted");
    } else {
        return $response->withStatus(422)->write($result);
    }
});

$app->put('/todo/{id}/', function ($request, $response) 
use ($container) {
    $todo   = new TodoRepository\Api\Todo($container['db']);
    $id     = $request->getAttribute('id');
    $todos  = $request->getParam('todo');
    $cat    = $request->getParam('cat');
    $desc   = $request->getParam('desc');
    $result = $todo->updateTodo($todos, $cat, $desc, $id);
    if ($result === TRUE) {
        return $response->withStatus(200)->write("updated");
    } else {
        return $response->withStatus(422)->write($result);
    }
});

$app->run();