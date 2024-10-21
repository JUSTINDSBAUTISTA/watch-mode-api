<?php
require_once 'loadenv.php'; // Load environment variables

// Use the API key from .env
define("API_KEY", $_ENV['WATCHMODE_API_KEY']);

require_once 'functions/fetch-details-by-titleId.php';

require_once 'functions/search-titles.php';

require_once 'functions/fetch-cast-and-crew-by-titleId.php';

require_once 'functions/get-genre.php';

require_once 'functions/fetch-new-release.php';

require_once 'functions/fetch-sources.php';

require_once 'functions/fetch-flags.php';