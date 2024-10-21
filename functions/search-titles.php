<?php
/**
 * Search titles by keyword and optional year, with pagination and dynamic search type.
 *
 * @param string $keyword
 * @param int|null $year
 * @param int $searchType
 * @param int $page
 * @param int $itemsPerPage
 * @return array
 */
function searchTitles($keyword, $year = null, $searchType = 1, $page = 1, $itemsPerPage = 20) {
    // Include the dynamic searchType in the API request
    $url = "https://api.watchmode.com/v1/autocomplete-search/?apiKey=" . API_KEY . "&search_value=$keyword&search_type=$searchType";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);
    $results = [];

    if (!empty($data['results'])) {
        // Loop through the results
        foreach ($data['results'] as $result) {
            // Skip the result if 'type' is null or empty
            if (empty($result['type'])) {
                continue; // Skip this result
            }

            // Apply the year filter to the results if specified
            if ($year && isset($result['year']) && $result['year'] != $year) {
                continue; // Skip this result if it doesn't match the year filter
            }

            // Prepare the result array, ensure each field exists before adding it
            $resultData = [
                'name' => $result['name'] ?? 'N/A',
                'relevance' => $result['relevance'] ?? 0,
                'id' => $result['id'] ?? 'N/A',
                'year' => isset($result['year']) ? $result['year'] : 'N/A',
                'result_type' => $result['result_type'] ?? 'N/A',
                'imdb_id' => $result['imdb_id'] ?? 'N/A',
                'tmdb_id' => $result['tmdb_id'] ?? 'N/A',
                'tmdb_type' => $result['tmdb_type'] ?? 'N/A',
                'image_url' => $result['image_url'] ?? 'default-small.jpg',
                'type' => ucwords(strtolower($result['type'])) // Capitalize 'type'
            ];

            // Add to the results array
            $results[] = $resultData;
        }
    }

    return ['results' => $results, 'totalResults' => count($results), 'requestMade' => $url];
}
