<?php


namespace app\core;


use app\core\middlewares\BaseMidleware;

class Controller
{
    public string $layout = 'main';
    public string $action = '';
    /**
     * @var BaseMidleware[]
     */
    protected array $middlewares = [];

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function render($view, $title, $styles = "", $params = [])
    {
        return Application::$app->router->renderView($view, $title, $styles, $params);
    }

    public function registerMiddleware(BaseMidleware $middleware)
    {
        $this->middlewares[]=$middleware;
    }

    /**
     * @return BaseMidleware[]
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}