<?php
require_once 'functions.php'; // Include the reusable functions

header('Content-Type: application/json');

// Fetch suggestions dynamically from the Watchmode API
if (isset($_GET['suggestion'])) {
    $keyword = urlencode($_GET['suggestion']);
    $url = "https://api.watchmode.com/v1/autocomplete-search/?apiKey=" . API_KEY . "&search_value=$keyword&search_type=1";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $response = curl_exec($ch);
    curl_close($ch);
    
    $data = json_decode($response, true);
    $suggestions = [];

    if (!empty($data['results'])) {
        foreach ($data['results'] as $result) {
            $suggestions[] = [
                'title' => $result['title'],
                'watchmodeId' => $result['id'],
                'poster' => $result['image_url'] ?? 'default-small.jpg',
            ];
        }
    }
    
    echo json_encode($suggestions);
    exit;
}

// Main search logic with pagination
if (isset($_GET['title'])) {
    $keyword = urlencode($_GET['title']);
    $year = $_GET['year'] ?? null;
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $itemsPerPage = isset($_GET['itemsPerPage']) ? (int) $_GET['itemsPerPage'] : 20;

    $data = searchTitles($keyword, $year, $page, $itemsPerPage);
    echo json_encode($data);
    exit;
}
