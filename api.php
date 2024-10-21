<?php
require_once 'functions.php';
header('Content-Type: application/json');

// Main search logic
if (isset($_GET['title'])) {
    // Sanitize and prepare the input parameters
    $keyword = urlencode(trim($_GET['title'])); // Ensure keyword is properly sanitized
    $year = isset($_GET['year']) ? (int)$_GET['year'] : null; // Cast year to integer, allow null if not provided
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Default page to 1
    $itemsPerPage = isset($_GET['itemsPerPage']) ? (int)$_GET['itemsPerPage'] : 20; // Default items per page to 20
    $searchType = isset($_GET['searchType']) ? (int)$_GET['searchType'] : 1; // Default searchType to 1 (All Titles & People)

    try {
        // Call the searchTitles function with dynamic parameters
        $data = searchTitles($keyword, $year, $searchType, $page, $itemsPerPage);

        // If no data is found, return a message
        if (!$data || empty($data['results'])) {
            throw new Exception('No results found.');
        }

        // Return the data as a JSON response
        echo json_encode($data);
    } catch (Exception $e) {
        // Log the error and return a JSON error message
        error_log("Error in API: " . $e->getMessage());
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit;
} else {
    // Return an error message if no title parameter is provided
    echo json_encode(['error' => 'No title provided.']);
    exit;
}
?>
