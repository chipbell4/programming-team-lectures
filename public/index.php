<?php

require_once('../vendor/autoload.php');

$app = new Slim\Slim();
$controller = new LectureController();

$app->get('/', function() use ($controller) {
    echo $controller->index();
});

$app->get('/lectures/:lecture', function($lecture) use ($controller) {
    echo $controller->showLecture($lecture);
});

$app->run();
