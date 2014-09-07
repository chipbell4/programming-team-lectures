<?php

require_once('../vendor/autoload.php');

$controller = new LectureController();

if (array_key_exists('lecture', $_GET)) {
    echo $controller->showLecture($_GET['lecture']);
} else {
    echo $controller->index();
}
