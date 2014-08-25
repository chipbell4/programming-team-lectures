<?php
require_once('../vendor/autoload.php');

class LectureController
{
    public function __construct()
    {
        $loader = new Twig_Loader_Filesystem($this->templateDir());
        $this->twig = new Twig_Environment($loader);
    }

    /**
     * Lists all lectures
     */
    public function index()
    {
        $lectures = $this->getAllLectures();
        return $this->render('index.html', compact('lectures'));
    }

    protected function getAllLectures()
    {
        $files = [];
        exec('ls ' . $this->templateDir('lectures'), $files);

        return array_map([$this, 'convertFileNameToTemplateData'], $files);
    }

    protected function templateDir($child_directory = '')
    {
        return __DIR__ . '/../templates/' . $child_directory;
    }

    protected function convertFileNameToTemplateData($filename)
    {
        $date = str_replace('.html', '', basename($filename));
        list($year, $month, $day) = explode('-', $date);
        return [
            'query_param' => $date,
            'pretty_date' => "$month/$day/$year"
        ];
    }

    public function showLecture($lecture)
    {
        return $this->render("lectures/$lecture.html");
    }

    /**
     * Called when no lecture provided
     */
    public function badFormat($lecture)
    {
        return $this->render('bad-format.html', compact('lecture'));
    }

    public function lectureNotFound($lecture)
    {
        return $this->render('no-lecture.html', compact('lecture'));
    }

    protected function render($template_name, array $template_variables = [])
    {
        return $this->twig->render($template_name, $template_variables);
    }
}
