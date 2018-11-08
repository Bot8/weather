<?php

return [
    /** Директория для экспорта */
    'export_path' => storage_path('weather'),

    /** Конфигурация клиентов API */
    'clients'     => [
        'openweathermap' => [
            'api_key' => env('OPENWEATHERMAP_API_KEY'),
        ]
    ],

    /** Форматы экпорта */
    'serializers' => [
        'xml'  => App\Services\WeatherService\Serializer\XmlSerializer::class,
        'json' => App\Services\WeatherService\Serializer\JsonSerializer::class,
    ]
];
