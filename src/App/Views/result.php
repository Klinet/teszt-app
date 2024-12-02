<!DOCTYPE html>
<html lang="en">
<head>
    <title>OrvosKereső</title>
    <meta name="description" content="Search the web for sites and images.">
    <meta name="keywords" content="Search engine, doodle, websites">
    <meta name="author" content="Reece Kenney">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div class="wrapper">
    <main id="indexPage" class="mainSection">
        <section>
            <div class="py-10 h-screen bg-gray-300 px-2">
                <div class="max-w-md mx-auto bg-gray-100 shadow-lg rounded-lg overflow-hidden md:max-w-lg">
                    <div class="md:flex">
                        <div class="w-full p-4">
                            <img src="<?php echo \App\Config\Config::get('base_url') . 'assets/images/foglaljorvostLogo.png'; ?>"
                                 title="Logo of our site" alt="Site logo">
                            <hr>
                            <header class="bg-white">
                                <div class="flex justify-between px-4 py-3">
                                    <form action="<?php echo \App\Config\Config::get('base_url') . 'submit-form' ?>" method="POST" class="flex w-full gap-2">
                                        <input type="text"
                                               class="flex-grow h-12 rounded focus:outline-none px-3 focus:shadow-md"
                                               placeholder="Keresendő Név vagy Szak..." name="term" value="Bőrgyógyász"
                                               autocomplete="off">
                                        <button style="background-color: #79b256" class="px-4 py-1 text-sm text-white rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300" type="submit">Keress!</button>
                                        <a href="/" style="background-color: #4782a1" class="px-4 py-3 text-sm text-white rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">Ürít</a>
                                    </form>
                                </div>
                            </header>
                            <div id="listing">
                                <?php echo $list ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>
</body>