<?php

namespace App\Config;

class Config
{
    private static array $config;
    public static function getConfig(): array
    {
        self::$config = [
            'base_url' => 'http://localhost/',
            'data_file' => base_path('Data/orvosok.json'),
            'db' => [
                'dsn' => 'mysql:dbname=doodle;host=localhost',
                'username' => 'root',
                'password' => ''
            ],
        ];
        return self::$config;
    }

    public static function get($key, $default = null)
    {
        $config = self::getConfig();
        return $config[$key] ?? $default;
    }
}