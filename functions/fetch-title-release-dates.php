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
    $processedIds = []; // To track IDs that have already been processed

    if (!empty($data)) {
        foreach ($data as $release) {
            // Manually filter for region 'US' only
            if (isset($release['region']) && $release['region'] === 'US') {
                $titleId = $release['id'] ?? null;

                // Check if the titleId exists and has not already been processed
                if ($titleId && !in_array($titleId, $processedIds)) {
                    // Add the titleId to the processed list to avoid duplicates
                    $processedIds[] = $titleId;

                    // Add the release data to the results array
                    $results[] = [
                        'id' => $release['id'] ?? 'N/A',
                        'title' => $release['title'] ?? 'N/A',
                        'title_type' => $release['title_type'] ?? 'N/A',
                        'type' => $release['type'] ?? 'N/A',
                        'release_date' => $release['release_date'] ?? 'N/A',
                        'region' => $release['region']
                    ];
                }
            }
        }
    }

    return $results;
}
