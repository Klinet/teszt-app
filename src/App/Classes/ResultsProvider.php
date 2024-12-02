<?php

namespace App\Classes;

use App\Models\DataModel;
use Exception;

class ResultsProvider
{
    private $data;

    public function __construct($term)
    {
        $jsonContent = DataModel::getData();
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Error decoding JSON: " . json_last_error_msg());
        }
        $result = $this->searchDoctorsAndClinics($jsonContent, $term);
        $this->data = $this->generateList($jsonContent, $result);
    }

    public function getData()
    {
        return $this->data;
    }

    private function searchDoctorsAndClinics($data, $term): array
    {
        $termLower = strtolower($term);

        $matchedDoctors = array_filter($data['doctors'], function ($doctor) use ($termLower) {
            return strpos(strtolower($doctor['name']), $termLower) !== false ||
                strpos(strtolower($doctor['specialty']), $termLower) !== false;
        });

        $matchedClinics = array_filter($data['clinics'], function ($clinic) use ($termLower) {
            return strpos(strtolower($clinic['name']), $termLower) !== false;
        });

        $doctorIds = array_column($matchedDoctors, 'id');
        $relatedClinicIds = array_unique(array_column(array_filter($data['doctor-clinic'], function ($relation) use ($doctorIds) {
            return in_array($relation['doctor_id'], $doctorIds);
        }), 'clinic_id'));

        $relatedClinics = array_filter($data['clinics'], function ($clinic) use ($relatedClinicIds) {
            return in_array($clinic['id'], $relatedClinicIds);
        });

        return [
            'doctors' => $matchedDoctors,
            'clinics' => $matchedClinics,
            'related_clinics' => $relatedClinics
        ];
    }

    private function findClinicsByDoctorId($data, $doctorId)
    {
        $relatedClinicIds = array_filter($data['doctor-clinic'], function ($relation) use ($doctorId) {
            return $relation['doctor_id'] === $doctorId;
        });

        return array_map(function ($relation) {
            return $relation['clinic_id'];
        }, $relatedClinicIds);
    }

    private function findClinicNamesByIds($data, $clinicIds): array
    {
        $clinicNames = [];
        foreach ($clinicIds as $clinicId) {
            foreach ($data['clinics'] as $clinic) {
                if ($clinic['id'] === $clinicId) {
                    $clinicNames[] = $clinic['name'];
                }
            }
        }
        return $clinicNames;
    }

    function generateList($jsonContent, $result): string
    {
        $clinicNames = [];
        foreach ($jsonContent['clinics'] as $clinic) {
            $clinicNames[$clinic['id']] = $clinic['name'];
        }
        $list = '<ul class="d-inline-block w-100">';
        foreach ($result['doctors'] as $doctor) {
            $relatedClinicIds = $this->findClinicsByDoctorId($jsonContent, $doctor['id']);
            $relatedClinicNames = $this->findClinicNamesByIds($jsonContent, $relatedClinicIds);
            $list .= '<li class="flex justify-between items-center bg-white mt-2 p-2 hover:shadow-lg rounded cursor-pointer transition">';
            $list .= '<div class="flex ml-2"><img src="https://fakeimg.pl/350x200/?text=Hello" width="40" height="40" class="rounded-full" alt="fakeimg">';
            $list .= '<div class="flex flex-col ml-2"><span class="font-medium text-black">' . htmlspecialchars($doctor['name']) . '</span>';
            $list .= '<span class="text-sm text-gray-400 truncate w-32">' . htmlspecialchars($doctor['specialty']) . '</span></div></div>';
            $list .= '<div class="flex flex-col text-right"><span class="text-gray-500">Klinika:<br>';
            $list .= '<div class="flex flex-col text-right"><span class="text-gray-500">' . implode(', ', $relatedClinicNames) . '<br>';
            $list .= '</span></div></li>';
        }
        $list .= '</ul>';
        return $list;
    }
}