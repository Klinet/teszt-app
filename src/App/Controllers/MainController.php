<?php

namespace App\Controllers;
use App\Models\DataModel;

class MainController
{
    private ?string $list;

    public function index($list = null): void
    {
        $data = DataModel::getData();
        $list = $this->mainList($data);
        $this->render(compact( 'list'));
    }


    public function render($list): void
    {
        extract($list);
        require __DIR__ . '/../Views/search.php';
    }

    public function mainList($data): string
    {
        $list = '<ul class="d-inline-block w-100">';
        if (!empty($data['doctors'])) {
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

            foreach ($data['doctors'] as $doctor) {
                $list .= '<li class="flex justify-between items-center bg-white mt-2 p-2 hover:shadow-lg rounded cursor-pointer transition">';
                $list .= '<div class="flex ml-2"><img src="https://fakeimg.pl/350x200/?text=Hello" width="40" height="40" class="rounded-full">';
                $list .= '<div class="flex flex-col ml-2"><span class="font-medium text-black">' . htmlspecialchars($doctor['name']) . '</span>';
                $list .= '<span class="text-sm text-gray-400 truncate w-32">' . htmlspecialchars($doctor['specialty']) . '</span></div></div>';
                $list .= '<div class="flex flex-col text-right"><span class="text-gray-500">Klinika:<br>';
                if (!empty($doctorClinics[$doctor['id']])) {
                    $clinics = array_map(function ($clinicId) use ($clinicNames) {
                        return $clinicNames[$clinicId] ?? 'Ismeretlen Klinika';
                    }, $doctorClinics[$doctor['id']]);
                    $list .= htmlspecialchars(implode(', ', $clinics));
                } else {
                    $list .= 'Nincs klinika hozzárendelve';
                }
                $list .= '</span></div></li>';
            }
        } else {
            $list .= '<li class="flex justify-between items-center bg-white mt-2 p-2 hover:shadow-lg rounded cursor-pointer transition">';
            $list .= '<div class="flex ml-2">Nincs elérhető adat.</div></li>';
        }
        $list .= '</ul>';

        return $list;
    }
}