<?php
require_once 'functions.php'; // Ensure this points to the correct file

// Call the fetchTitleReleaseDates function
$releaseDates = fetchTitleReleaseDates();

// Print the results, including region
echo "Fetched Release Dates (Filtered for Region 'US'):\n";
print_r($releaseDates);
