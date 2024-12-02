<?php

namespace App\Controllers;
use App\Classes\ResultsProvider;

class SearchController
{
    public function submitForm($request): void
    {
        $term = $request->postData['term'] ?? '';
        $term = htmlspecialchars($term, ENT_QUOTES, 'UTF-8');
        try {
            $resultsProvider = new ResultsProvider($term);
            $data = $resultsProvider->getData();
            pretty_var_export($data);

        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function render($data): void
    {
        extract($data);
        //$viewPath = __DIR__ . '/../Views/' . 'index' . '.php';
        $viewPath = __DIR__ . '/../Views/' . 'search' . '.php';
        require __DIR__ . '/../Views/layout.php';
    }
}