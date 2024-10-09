<?php
require_once 'loadenv.php'; // Load environment variables

// Use the API key from .env
define("API_KEY", $_ENV['WATCHMODE_API_KEY']);

/**
 * Fetch details by Watchmode ID.
 *
 * @param int $watchmodeId
 * @return array|null
 */
function fetchDetailsByWatchmodeId($watchmodeId) {
    $url = "https://api.watchmode.com/v1/title/$watchmodeId/details/?apiKey=" . API_KEY . "&append_to_response=sources";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    $decodedResponse = json_decode($response, true);

    if (isset($decodedResponse['success']) && $decodedResponse['success'] === false) {
        return null; // Title not found, return null to indicate failure
    }

    return $decodedResponse;
}

/**
 * Search titles by keyword and optional year, with pagination.
 *
 * @param string $keyword
 * @param int|null $year
 * @param int $page
 * @param int $itemsPerPage
 * @return array
 */
function searchTitles($keyword, $year = null, $page = 1, $itemsPerPage = 20) {
    $url = "https://api.watchmode.com/v1/autocomplete-search/?apiKey=" . API_KEY . "&search_value=$keyword&search_type=1";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);
    $results = [];
    
    if (!empty($data['results'])) {
        foreach ($data['results'] as $result) {
            $details = fetchDetailsByWatchmodeId($result['id']);
            if ($details) {
                $results[] = $details;
            }
        }
    }
    
    return ['results' => $results, 'totalResults' => count($results)];
}
