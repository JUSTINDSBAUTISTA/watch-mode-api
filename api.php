<?php
define("API_KEY", "AnISQaWQOo81g1hfdRnHaUXsr2DGp5HIY4hzyNUW"); // Replace with your actual API key
define("CSV_FILE", "titles.csv");

header('Content-Type: application/json');

function searchCsvForTitle($keyword) {
    $watchmodeIds = [];
    if (($handle = fopen(CSV_FILE, "r")) !== FALSE) {
        fgetcsv($handle); // Skip header row

        while (($data = fgetcsv($handle)) !== FALSE) {
            $title = $data[4];
            if (stripos($title, $keyword) !== false) {
                $watchmodeIds[] = $data[0];
            }
        }
        fclose($handle);
    }
    return $watchmodeIds;
}

function fetchDetailsByWatchmodeId($watchmodeId) {
    $url = "https://api.watchmode.com/v1/title/$watchmodeId/details/?apiKey=" . API_KEY . "&append_to_response=sources";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

if (isset($_GET['title'])) {
    $keyword = $_GET['title'];
    $watchmodeIds = searchCsvForTitle($keyword);
    $results = [];

    foreach ($watchmodeIds as $id) {
        $details = fetchDetailsByWatchmodeId($id);
        if ($details) {
            $results[] = $details;
        }
    }

    echo json_encode($results);
}

if (isset($_GET['details'])) {
    $watchmodeId = $_GET['details'];
    echo json_encode(fetchDetailsByWatchmodeId($watchmodeId));
}
?>
