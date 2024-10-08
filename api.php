<?php
require_once 'loadenv.php'; // Load environment variables

define("API_KEY", $_ENV['WATCHMODE_API_KEY']); // Use the API key from .env
define("CSV_FILE", "titles.csv");

header('Content-Type: application/json');

// Fetch paginated data from CSV
function searchCsvForTitleAndYear($keyword, $year, $page, $itemsPerPage) {
    $watchmodeIds = [];
    $totalResults = 0;
    $start = ($page - 1) * $itemsPerPage;
    $end = $start + $itemsPerPage;
    $results = [];

    if (($handle = fopen(CSV_FILE, "r")) !== FALSE) {
        fgetcsv($handle); // Skip header row
        $index = 0;

        while (($data = fgetcsv($handle)) !== FALSE) {
            $title = $data[4];
            $titleYear = $data[5]; // Assuming year is in the 6th column (index 5)
            
            // Match title keyword and year if specified
            if (stripos($title, $keyword) !== false && (!$year || $titleYear == $year)) {
                $totalResults++;
                
                // Only add rows within the current page range
                if ($index >= $start && $index < $end) {
                    $watchmodeIds[] = $data[0];
                }
                $index++;
            }
        }
        fclose($handle);
    }

    // Fetch details for each Watchmode ID in the current page
    foreach ($watchmodeIds as $id) {
        $details = fetchDetailsByWatchmodeId($id);
        if ($details) {
            $results[] = $details;
        }
    }

    return ['results' => $results, 'totalResults' => $totalResults];
}

// Fetch details for a given Watchmode ID
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

// Main logic for handling title searches and pagination
if (isset($_GET['title'])) {
    $keyword = $_GET['title'];
    $year = $_GET['year'] ?? null;
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $itemsPerPage = isset($_GET['itemsPerPage']) ? (int) $_GET['itemsPerPage'] : 20;

    $data = searchCsvForTitleAndYear($keyword, $year, $page, $itemsPerPage);
    echo json_encode($data);
}

// Fetch details by Watchmode ID
if (isset($_GET['details'])) {
    $watchmodeId = $_GET['details'];
    echo json_encode(fetchDetailsByWatchmodeId($watchmodeId));
}
?>
