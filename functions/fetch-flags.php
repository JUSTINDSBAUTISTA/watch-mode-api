<?php
require_once 'loadenv.php'; // Load environment variables

function fetchFlags() {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.watchmode.com/v1/regions/?apiKey=' . API_KEY);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    $regions = json_decode($response, true);

    $flags = [];
    // Loop through each region and extract only necessary fields
    foreach ($regions as $region) {
        if (!empty($region['flag'])) {
            $flags[] = [
                'country' => $region['country'],
                'name' => $region['name'],
                'flag' => $region['flag']
            ];
        }
    }

    return $flags;
}
