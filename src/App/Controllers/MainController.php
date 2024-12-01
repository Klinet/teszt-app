<?php

namespace App\Controllers;
use App\Models\DataModel;

class MainController
{
    public function index(): void
    {
        $data = [];
        $data = DataModel::getData();
        $this->render(compact('data'));
    }

    private function render($data = []): void
    {
        extract($data);
        $viewPath = __DIR__ . '/../Views/' . 'index' . '.php';
        require __DIR__ . '/../Views/layout.php';
    }
}