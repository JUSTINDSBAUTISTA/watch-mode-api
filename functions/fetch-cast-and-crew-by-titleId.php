<?php
/**
 * Fetch cast and crew by Watchmode ID.
 *
 * @param int $titleId
 * @return array|null
 */
function fetchCastAndCrewByTitleId($titleId) {
    $url = "https://api.watchmode.com/v1/title/$titleId/cast-crew/?apiKey=" . API_KEY;
    
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
