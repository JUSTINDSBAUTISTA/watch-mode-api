<?php
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
            // Apply the year filter to the results if specified
            if ($year && isset($result['year']) && $result['year'] != $year) {
                continue; // Skip this result if it doesn't match the year filter
            }
            $details = fetchDetailsByWatchmodeId($result['id']);
            if ($details) {
                $results[] = $details;
            }
        }
    }

    return ['results' => $results, 'totalResults' => count($results)];
}
