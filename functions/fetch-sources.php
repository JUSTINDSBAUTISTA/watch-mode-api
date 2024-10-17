<?php

function fetchSources($types = [], $user_region = 'US') {
    $url = "https://api.watchmode.com/v1/sources/?apiKey=" . API_KEY;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    $json = json_decode($response, true);

    // Filter sources by user region and group by type
    $sources_by_type = [];
    foreach ($json as $source) {
        if (in_array($user_region, $source['regions'])) {
            $sources_by_type[$source['type']][] = $source;
        }
    }

    return $sources_by_type;
}
