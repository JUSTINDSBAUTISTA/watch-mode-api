<?php
/**
 * Fetch details by Watchmode ID.
 *
 * @param int $personId
 * @return array|null
 */
function fetchDetailByPersonId($personId) {
    $url = "https://api.watchmode.com/v1/person/$personId?apiKey=" . API_KEY;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    $decodedResponse = json_decode($response, true);

    return $decodedResponse;
}
