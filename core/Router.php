<?php

namespace app\core;

use app\core\exception\NotFoundException;

class Router
{
    protected array $routes = [];
    protected array $regexRoutes = [];
    public Request $request;
    public Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function getRegex($expression, $callback)
    {
        $this->regexRoutes['get'][$expression] = $callback;
    }

    public function postRegex($expression, $callback)
    {
        $this->regexRoutes['post'][$expression] = $callback;
    }

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function put($path, $callback)
    {
        $this->routes['put'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->method();

        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
            foreach ($this->regexRoutes[$method] as $key => $value) {
                if (preg_match($key, $path)) {
                    $callback = $this->regexRoutes[$method][$key];
                    break;
                }
            }
            if ($callback === false) {
                throw new NotFoundException();
            }
        }
        if (is_string($callback)) {

            return $this->renderView($callback, "", "");
        }
        if (is_array($callback)) {
            /**
             * @var Controller $controller
             */
            $controller = new $callback[0]();
            Application::$app->controller = $controller;
            $controller->action = $callback[1];
            $callback[0] = $controller;

            foreach ($controller->getMiddlewares() as $middleware) {
                $middleware->execute();
            }
        }

        return call_user_func($callback, $this->request, $this->response);
    }

    public function renderView($view, $title, $styles, $params = [])
    {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view, $params);
        $layoutContent = str_replace("{{title}}", $title, $layoutContent);
        $layoutContent = str_replace('{{styles}}', $styles, $layoutContent);
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    public function renderContent($viewContent, $styles)
    {
        $layoutContent = $this->layoutContent();
        $layoutContent = str_replace('{{styles}}', $styles, $layoutContent);
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    protected function layoutContent()
    {
        $layout = Application::$app->layout;

        if (Application::$app->controller) {
            $layout = Application::$app->controller->layout;
        }
        ob_start();
        include_once Application::$ROOT_DIR . "/views/layouts/$layout.php";
        return ob_get_clean();
    }

    protected function renderOnlyView($view, $params)
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }

        ob_start();
        include_once Application::$ROOT_DIR . "/views/$view.php";
        return ob_get_clean();
    }
}