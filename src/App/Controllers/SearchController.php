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
            $list = $resultsProvider->getData();
            //pretty_var_export($list); die();
            $this->render($list);

        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function render($list): void
    {
        // ezt kell: $list
        require __DIR__ . '/../Views/result.php';
    }
}