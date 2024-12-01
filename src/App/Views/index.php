<?php

use App\Classes\Request;
use App\Classes\Router;
use App\Controllers\SearchController;

$router = new Router();

$router->addRoute('POST', '/submit-form', function() {
    $request = new Request();
    $controller = new SearchController();
    $controller->submitForm($request);
});

$router->dispatch();

?>
<main id="indexPage" class="mainSection">
    <section class="logoContainer">
        <img src="<?php echo \App\Config\Config::get('base_url') . 'assets/images/foglaljorvostLogo.png'; ?>" title="Logo of our site" alt="Site logo">
    </section>
    <section class="searchContainer">
        <form action="<?php echo \App\Config\Config::get('base_url') . 'submit-form' ?>" method="POST">
            <input type="hidden" name="type" value="sites">
            <input class="searchBox" type="text" name="term" value="Bőrgyógyász" placeholder="Bőrgyógyász" autocomplete="off">
            <input class="searchButton" type="submit" value="Search">
        </form>
    </section>
    <section>
        <h2>Data from JSON</h2>
        <?php if (!empty($data)): ?>
            <article>
                <?php echo pretty_var_export($data, true); ?>
            </article>
        <?php else: ?>
            <p>No data available.</p>
        <?php endif; ?>
    </section>
</main>