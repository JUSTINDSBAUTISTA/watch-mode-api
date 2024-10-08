<?php
require_once 'loadenv.php'; // Load environment variables

define("API_KEY", $_ENV['WATCHMODE_API_KEY']); // Use the API key from .env
define("CSV_FILE", "titles.csv");

header('Content-Type: application/json');

function searchCsvForTitleAndYear($keyword, $year) {
    $watchmodeIds = [];
    if (($handle = fopen(CSV_FILE, "r")) !== FALSE) {
        fgetcsv($handle); // Skip header row

        while (($data = fgetcsv($handle)) !== FALSE) {
            $title = $data[4];
            $titleYear = $data[5];  // Assuming year is in the 6th column (index 5)
            
            if (stripos($title, $keyword) !== false) {
                // Check if title matches the specified year if provided
                if (!$year || $titleYear == $year) {
                    $watchmodeIds[] = $data[0];
                }
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

function isWatchmodeId($input) {
    return ctype_digit($input);
}

if (isset($_GET['title'])) {
    $keyword = $_GET['title'];
    $year = $_GET['year'] ?? null;  // Get specific year from request
    
    $results = [];

    // Check if input is a Watchmode ID
    if (isWatchmodeId($keyword)) {
        $details = fetchDetailsByWatchmodeId($keyword);
        if ($details) {
            $results[] = $details;
        }
    } else {
        $watchmodeIds = searchCsvForTitleAndYear($keyword, $year);
        
        foreach ($watchmodeIds as $id) {
            $details = fetchDetailsByWatchmodeId($id);
            if ($details) {
                $results[] = $details;
            }
        }
    }

    echo json_encode($results);
}

if (isset($_GET['details'])) {
    $watchmodeId = $_GET['details'];
    echo json_encode(fetchDetailsByWatchmodeId($watchmodeId));
}
?>
