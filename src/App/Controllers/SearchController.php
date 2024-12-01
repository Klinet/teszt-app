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
            $results = $resultsProvider->getData();
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}