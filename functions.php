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

/**
 * Fetch cast and crew by Watchmode ID.
 *
 * @param int $watchmodeId
 * @return array|null
 */
function fetchCastAndCrewByWatchmodeId($watchmodeId) {
    $url = "https://api.watchmode.com/v1/title/$watchmodeId/cast-crew/?apiKey=" . API_KEY;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    $decodedResponse = json_decode($response, true);

    if (json_last_error() === JSON_ERROR_NONE) {
        return $decodedResponse;
    }

    return null;
}

function getGenreClass($genreName) {
    $genreClasses = [
        'Action' => 'genre-action',
        'Action & Adventure' => 'genre-action-adventure',
        'Adult' => 'genre-adult',
        'Adventure' => 'genre-adventure',
        'Animation' => 'genre-animation',
        'Anime' => 'genre-anime',
        'Biography' => 'genre-biography',
        'Comedy' => 'genre-comedy',
        'Crime' => 'genre-crime',
        'Documentary' => 'genre-documentary',
        'Drama' => 'genre-drama',
        'Family' => 'genre-family',
        'Fantasy' => 'genre-fantasy',
        'Food' => 'genre-food',
        'Game Show' => 'genre-game-show',
        'History' => 'genre-history',
        'Horror' => 'genre-horror',
        'Kids' => 'genre-kids',
        'Music' => 'genre-music',
        'Musical' => 'genre-musical',
        'Mystery' => 'genre-mystery',
        'Nature' => 'genre-nature',
        'News' => 'genre-news',
        'Reality' => 'genre-reality',
        'Romance' => 'genre-romance',
        'Sci-Fi & Fantasy' => 'genre-sci-fi-fantasy',
        'Science Fiction' => 'genre-science-fiction',
        'Soap' => 'genre-soap',
        'Sports' => 'genre-sports',
        'Supernatural' => 'genre-supernatural',
        'Talk' => 'genre-talk',
        'Thriller' => 'genre-thriller',
        'Travel' => 'genre-travel',
        'TV Movie' => 'genre-tv-movie',
        'War' => 'genre-war',
        'War & Politics' => 'genre-war-politics',
        'Western' => 'genre-western',
    ];

    return $genreClasses[$genreName] ?? 'default-genre';
}
