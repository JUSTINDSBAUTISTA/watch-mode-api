<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php if (!empty($details['title'])): ?>
            <?php echo htmlspecialchars($details['title']); ?>
        <?php else: ?>
            Watchmode Api
        <?php endif; ?>
    </title>
    <link rel="icon" type="image/x-icon" sizes="180x180" href="favicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Custom Styles -->
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/index/styles.css">
    <link rel="stylesheet" href="css/index/components/cards.css">
    <link rel="stylesheet" href="css/show/styles.css">
    <link rel="stylesheet" href="css/show/genre.css">
    <link rel="stylesheet" href="css/show/components/cards.css">
    <link rel="stylesheet" href="css/show/components/spinner.css">
    <link rel="stylesheet" href="css/show/components/responsive-title.css">

    <script async src="javascript/header.js"></script>
    <script>
        const detailsData = <?php echo json_encode($details, JSON_PRETTY_PRINT); ?>;
    </script>
</head>