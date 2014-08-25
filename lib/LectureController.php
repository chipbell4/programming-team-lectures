<?php
require('vendor/autoload.php');

class LectureController
{
    public function __construct()
    {
        $loader = new Twig_Loader_Filesystem(__DIR__ . '/../templates');
        $this->twig = new Twig_Environment($loader);
    }

    /**
     * Called when no lecture provided
     */
    public function badFormat($lecture)
    {
        return $this->render('bad-format.html', compact('lecture'));
    }

    protected function render($template_name, array $template_variables = [])
    {
        return $this->twig->render($template_name, $template_variables);
    }
}
