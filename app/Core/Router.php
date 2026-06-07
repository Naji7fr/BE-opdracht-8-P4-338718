<?php

declare(strict_types=1);

class Router
{
    /** @var array<string, array<string, array{class: string, method: string}>> */
    private array $routes = [];

    public function get(string $path, string $controller, string $method): void
    {
        $this->addRoute('GET', $path, $controller, $method);
    }

    public function post(string $path, string $controller, string $method): void
    {
        $this->addRoute('POST', $path, $controller, $method);
    }

    private function addRoute(string $httpMethod, string $path, string $controller, string $method): void
    {
        $this->routes[$httpMethod][$path] = [
            'class' => $controller,
            'method' => $method,
        ];
    }

    public function dispatch(): void
    {
        $httpMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $url = $_GET['url'] ?? '/';
        $url = '/' . trim((string) $url, '/');
        if ($url === '/') {
            $url = '/';
        }

        if (!isset($this->routes[$httpMethod][$url])) {
            http_response_code(404);
            echo 'Pagina niet gevonden.';
            return;
        }

        $route = $this->routes[$httpMethod][$url];
        $controller = new $route['class']();
        $controller->{$route['method']}();
    }
}
