<?php
/**
 * Fetch details by Watchmode ID.
 *
 * @param int $titleId
 * @return array|null
 */
function fetchDetailsByTitleId($titleId) {
    $url = "https://api.watchmode.com/v1/title/$titleId/details/?apiKey=" . API_KEY . "&append_to_response=sources";
    
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
