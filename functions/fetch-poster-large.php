<?php
/**
 * Fetch the large poster by Watchmode ID.
 *
 * @param int $titleId
 * @return string|null
 */
function fetchPosterLargeByTitleId($titleId) {
    $url = "https://api.watchmode.com/v1/title/$titleId/details/?apiKey=" . API_KEY . "&append_to_response=sources";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    $decodedResponse = json_decode($response, true);

    // Check if the response is valid and contains the posterLarge field
    if (isset($decodedResponse['posterLarge'])) {
        return $decodedResponse['posterLarge'];
    }

    return null; // Return null if posterLarge is not found or if the request fails
}
