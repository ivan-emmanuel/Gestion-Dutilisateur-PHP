<?php


namespace Application\Template;


use Application\Paths;
use http\Env\Response;
use Psr\Http\Message\ResponseInterface;

class TemplateEngine
{

    /**
     * @var string
     */
    private $template_path;

    private $layout = "default";
    private $data = [];

    private static $instance = null;

    public function __construct(string  $template_path)
    {
        $this->template_path = $template_path;
    }

    public static function Instance(){
        if (is_null(self::$instance)){
            self::$instance = new TemplateEngine(Paths::Instance()->View());
        }
        return self::$instance;
    }

    /**
     * @param array $data
     */
    public function AddData(array $data): void
    {
        $this->data = array_merge($data,$this->data);
    }

    public static function pageTitle($title)
    {
        self::Instance()->AddData(['title'=>$title]);
    }



    public function setLayout($layout = 'default') {
        $this->layout = $layout ;
    }

    public  function render($page,$vars = []){
        extract($vars);
        extract($this->data);
        ob_start();
        require Paths::Instance()->View($page.'.php');
        $content = ob_get_clean();
        require Paths::Instance()->layout($this->layout.'.php');
        session_instance()->delete('_data');
    }



}