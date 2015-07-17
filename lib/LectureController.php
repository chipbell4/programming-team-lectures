<?php
require_once('../vendor/autoload.php');

class LectureController
{
    /**
     * Creates a new controller, booting up the twig renderer
     */
    public function __construct()
    {
        $loader = new Twig_Loader_Filesystem($this->templateDir());
        $this->twig = new Twig_Environment($loader);
    }

    /**
     * Called when no lecture provided
     *
     * @param string $lecture The lecture that is in a bad format
     *
     * @return void
     */
    public function badFormat($lecture)
    {
        return $this->render('bad-format.html', ['lecture' => $lecture]);
    }
    
    /**
     * Converts the filename of a lecture to a template data that can be rendered in a view
     * 
     * @param string $filename The filename to convert to an array
     * 
     * @return array
     */
    protected function convertFileNameToTemplateData($filename)
    {
        $date = str_replace('.html', '', basename($filename));
        list($year, $month, $day) = explode('-', $date);
        return [
            'query_param' => $date,
            'pretty_date' => "$month/$day/$year"
        ];
    }
    
    /**
     * Gets all lectures in view format (nested arrays)
     *
     * @return array
     */
    protected function getAllLectures()
    {
        $files = [];
        exec('ls ' . $this->templateDir('lectures'), $files);

        return array_map([$this, 'convertFileNameToTemplateData'], $files);
    }

    /**
     * Lists all lectures
     *
     * @return void
     */
    public function index()
    {
        $lectures = $this->getAllLectures();
        return $this->render('index.html', compact('lectures'));
    }
    
    /**
     * Returns true if a given lecture is in the correct format to be found on disk
     * 
     * @param string $lecture The lecture to check
     * 
     * @return bool
     */
    protected function isLectureFormat($lecture)
    {
        return preg_match('/^\d\d\d\d-\d\d-\d\d$/', $lecture);
    }

    /**
     * Returns true if the given lecture exists 
     * 
     * @param string $lecture The lecture to check
     * 
     * @return bool
     */
    protected function lectureExists($lecture)
    {
        return file_exists($this->templateDir("lectures/$lecture.html"));
    }

    /**
     * Renders the not found page for a lecture (that apparently doesn't exist) 
     * 
     * @param string $lecture The lecture that didn't exist
     * 
     * @return void
     */
    public function lectureNotFound($lecture)
    {
        return $this->render('no-lecture.html', ['lecture' => $lecture]);
    }

    /**
     * Renders a given twig template with the provided variables
     * 
     * @param string $template_name      The name of the twig template to render
     * @param array  $template_variables The variables to bind to the template
     * 
     * @return string The string result of rendering the template
     */
    protected function render($template_name, array $template_variables = [])
    {
        return $this->twig->render($template_name, $template_variables);
    }

    /**
     * Attempts to render a given lecture
     * 
     * @param string $lecture The lecture to render
     * 
     * @return string
     */
    public function showLecture($lecture)
    {
        if (!$this->lectureExists($lecture)) {
            return $this->lectureNotFound($lecture);
        }

        return $this->render("lectures/$lecture.html");
    }

    /**
     * Builds the path to a template
     * 
     * @param string $child_directory An optional child directory to append to the end
     * 
     * @return string
     */
    protected function templateDir($child_directory = '')
    {
        return __DIR__ . '/../templates/' . $child_directory;
    }
}
