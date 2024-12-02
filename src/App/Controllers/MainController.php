<?php

namespace App\Controllers;
use App\Models\DataModel;

class MainController
{
    public function index(): void
    {
        $data = DataModel::getData();
        $this->render(compact('data'));
    }

    public function render($data): void
    {
        extract($data);
        //$viewPath = __DIR__ . '/../Views/' . 'index' . '.php';
        $viewPath = __DIR__ . '/../Views/' . 'search' . '.php';
        require __DIR__ . '/../Views/layout.php';
    }
}