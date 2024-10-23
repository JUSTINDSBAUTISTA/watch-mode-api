<?php

function fetchTitleReleaseDates() {
    $url = "https://api.watchmode.com/v1/title-release-dates/?apiKey=" . API_KEY;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    $results = [];

    if (!empty($data)) {
        foreach ($data as $release) {
            $titleId = $release['id'] ?? null;
            $region = $release['region'] ?? null;

            // Check if the titleId exists and if the region is 'US'
            if ($titleId && $region === 'US') {
                $results[] = [
                    'id' => $release['id'] ?? 'N/A',
                    'title' => $release['title'] ?? 'N/A',
                    'title_type' => $release['title_type'] ?? 'N/A',
                    'type' => $release['type'] ?? 'N/A',
                    'release_date' => $release['release_date'] ?? 'N/A',
                ];
            }
        }
    }

    return $results;
}
