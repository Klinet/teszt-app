<?php

namespace App\Controllers;
use App\Models\DataModel;

class MainController
{
    public function index()
    {
        $data = [];
        $data = DataModel::getData();
        $this->render('index', compact('data'));
    }

    private function render($view, $data = [])
    {
        extract($data);
        $viewPath = __DIR__ . '/../Views/' . $view . '.php';
        require __DIR__ . '/../Views/layout.php';
    }
}