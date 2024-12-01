<!DOCTYPE html>
<html lang="en">
<head>
    <title>OrvosKereső</title>
    <meta name="description" content="Search the web for sites and images.">
    <meta name="keywords" content="Search engine, doodle, websites">
    <meta name="author" content="Reece Kenney">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo \App\Config\Config::get('base_url') . 'assets/css/style.css'; ?>">
</head>
<body>
    <div class="wrapper">
        <header>
            <h1>Welcome to OrvosKereső App!</h1>
        </header>
            <?php include $viewPath; ?>
        <footer>
            <p>OrvosKereső App.</p>
        </footer>
    </div>
    <script src="<?php echo \App\Config\Config::get('base_url') . 'assets/js/script.js'; ?>" defer></script>
</body>
</html>