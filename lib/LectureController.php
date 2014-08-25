<?php
require('vendor/autoload.php');

class LectureController
{
    public function __construct()
    {
        $loader = new Twig_Loader_Filesystem(__DIR__ . '/../templates');
        $this->twig = new Twig_Environment($loader);
    }

    public function testIt()
    {
        return $this->render('asdf', array());
    }

    protected function render($template_name, array $template_variables = [])
    {
        return $this->twig->render($template_name, $template_variables);
    }
}
