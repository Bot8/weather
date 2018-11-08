<?php

namespace App\Service\WeatherService\Clients;

use App\Service\WeatherService\WeatherDTO;
use App\Services\WeatherService\Exceptions\ApiClientException;

interface WeatherApiClient
{
    /** Температура по Цельсию */
    public const METRIC_UNITS = 'metric';
    /** Температура по Фаренгейту */
    public const IMPERIAL_UNITS = 'imperial';

    public const TEMPERATURE_UNITS = [
        self::METRIC_UNITS   => '°C',
        self::IMPERIAL_UNITS => '°F',
    ];

    /**
     * @param string $city   Город
     * @param string $format Формат возвращаемых данных
     *
     * @return WeatherDTO
     * @throws ApiClientException
     */
    public function getWeather(string $city, string $format = self::METRIC_UNITS): ?WeatherDTO;
}