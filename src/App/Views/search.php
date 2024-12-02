<?php

use App\Classes\Request;
use App\Classes\Router;
use App\Controllers\SearchController;

$router = new Router();

$router->addRoute('POST', '/submit-form', function () {
    $request = new Request();
    $controller = new SearchController();
    $controller->submitForm($request);
});

$router->dispatch();

?>
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
                                    <button style="background-color: #79b256" class="px-4 py-2 text-sm text-white rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300" type="submit">Keress!</button>
                                </form>
                            </div>
                        </header>
                        <div class="">
                            <ul class="d-inline-block w-100">
                                <?php if (!empty($data['doctors'])): ?>
                                    <?php
                                    $clinicNames = [];
                                    foreach ($data['clinics'] as $clinic) {
                                        $clinicNames[$clinic['id']] = $clinic['name'];
                                    }
                                    $doctorClinics = [];
                                    foreach ($data['doctor-clinic'] as $relation) {
                                        if (!isset($doctorClinics[$relation['doctor_id']])) {
                                            $doctorClinics[$relation['doctor_id']] = [];
                                        }
                                        $doctorClinics[$relation['doctor_id']][] = $relation['clinic_id'];
                                    }
                                    ?>
                                    <?php foreach ($data['doctors'] as $doctor): ?>
                                        <li class="flex justify-between items-center bg-white mt-2 p-2 hover:shadow-lg rounded cursor-pointer transition">
                                            <div class="flex ml-2"><img src="https://fakeimg.pl/350x200/?text=Hello"
                                                                        width="40" height="40"
                                                                        class="rounded-full">
                                                <div class="flex flex-col ml-2"><span
                                                            class="font-medium text-black"><?= htmlspecialchars($doctor['name']) ?></span>
                                                    <span
                                                            class="text-sm text-gray-400 truncate w-32"><?= htmlspecialchars($doctor['specialty']) ?></span>
                                                </div>
                                            </div>
                                            <div class="flex flex-col text-right"><span class="text-gray-500">
                                            Klinika:<br>
                                                <?php
                                                if (!empty($doctorClinics[$doctor['id']])) {
                                                    $clinics = array_map(function ($clinicId) use ($clinicNames) {
                                                        return $clinicNames[$clinicId] ?? 'Ismeretlen Klinika';
                                                    }, $doctorClinics[$doctor['id']]);

                                                    echo htmlspecialchars(implode(', ', $clinics));
                                                } else {
                                                    echo 'Nincs klinika hozzárendelve';
                                                }
                                                ?>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <li class="flex justify-between items-center bg-white mt-2 p-2 hover:shadow-lg rounded cursor-pointer transition">
                                        <div class="flex ml-2">
                                            Nincs elérhető adat.
                                        </div>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>