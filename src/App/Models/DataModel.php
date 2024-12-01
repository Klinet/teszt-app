<?php

namespace App\Models;
use App\Config\Config;

class DataModel
{
    public static function getData()
    {
        $config = Config::getConfig();
        $dataJson = false;
        try {
            if (file_exists($config['data_file'])) {
                $dataJson = file_get_contents($config['data_file']);
            }
            if ($dataJson === false) {
                throw new \Exception("Failed to read data file.");
            }
            $data = json_decode($dataJson, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception("Failed to decode JSON: " . json_last_error_msg());
            }
            return $data;
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
}