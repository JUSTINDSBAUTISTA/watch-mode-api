<?php
/**
 * Fetches the latest releases from the Watchmode API within an optional date range.
 *
 * @param string $startDate Start date in format YYYYMMDD
 * @param string $endDate End date in format YYYYMMDD
 * @return array|null
 */
function fetchNewReleases($startDate, $endDate) {
    $url = "https://api.watchmode.com/v1/releases/?apiKey=" . API_KEY . "&start_date=$startDate&end_date=$endDate";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    
    $response = curl_exec($ch);
    
    if (curl_errno($ch)) {
        error_log("cURL Error: " . curl_error($ch));
        curl_close($ch);
        return []; // Return an empty array if there's an error
    }
    
    curl_close($ch);
    
    $decodedResponse = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log("JSON Decode Error: " . json_last_error_msg());
        return [];
    }

    return $decodedResponse['releases'] ?? [];
}

