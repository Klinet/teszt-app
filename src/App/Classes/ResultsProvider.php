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

    private function searchDoctorsAndClinics($data, $term)
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

    private function findClinicNamesByIds($data, $clinicIds)
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

    function generateList($jsonContent, $result)
    {
        $html = '<ul class="resultListUl">';
        foreach ($result['doctors'] as $doctor) {
            $relatedClinicIds = $this->findClinicsByDoctorId($jsonContent, $doctor['id']);
            $relatedClinicNames = $this->findClinicNamesByIds($jsonContent, $relatedClinicIds);
            $html .= '<hr><li>';
            $html .= '<strong>ID:</strong> ' . htmlspecialchars($doctor['id']) . '<br>';
            $html .= '<strong>Name:</strong> ' . htmlspecialchars($doctor['name']) . '<br>';
            $html .= '<strong>Specialty:</strong> ' . htmlspecialchars($doctor['specialty']) . '<br>';
            $html .= '<strong>Clinic Names:</strong> ' . implode(', ', $relatedClinicNames) . '<br>';
            $html .= '</li><hr>';
        }
        $html .= '</ul><hr>';
        return $html;
    }

    function safe_htmlspecialchars($value)
    {
        return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
    }
}