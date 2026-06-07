<?php

declare(strict_types=1);

class Controller
{
    protected function view(string $view, array $data = []): void
    {
        $data['baseUrl'] = $this->baseUrl('');
        extract($data, EXTR_SKIP);
        $viewPath = APP_PATH . '/Views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            throw new RuntimeException("View niet gevonden: {$view}");
        }

        require APP_PATH . '/Views/layout/header.php';
        require $viewPath;
        require APP_PATH . '/Views/layout/footer.php';
    }

    protected function redirect(string $path): void
    {
        header('Location: ' . $this->baseUrl($path));
        exit;
    }

    protected function baseUrl(string $path = ''): string
    {
        $scriptName = dirname($_SERVER['SCRIPT_NAME'] ?? '');
        $base = rtrim(str_replace('\\', '/', $scriptName), '/');

        return $base . $path;
    }
}
