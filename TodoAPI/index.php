<?php
require "vendor/autoload.php";

$todo = new TodoRepository\Todo();

var_dump($todo->getTodo(1));

