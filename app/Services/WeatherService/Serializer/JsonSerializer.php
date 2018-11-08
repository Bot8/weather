<?php

namespace App\Services\WeatherService\Serializer;

use App\Service\WeatherService\Serializer\SerializerInterface;
use App\Service\WeatherService\WeatherDTO;

class JsonSerializer implements SerializerInterface
{
    /** @inheritdoc */
    public function getFileName(string $name): string
    {
        return "{$name}.json";
    }
    
    /** @inheritdoc */
    public function serialize(WeatherDTO $dto): string
    {
        $date = $dto->getDate();

        return json_encode([
            'date'             => $date ? $date->getTimestamp() : null,
            'temperature'      => $dto->getTemperature(),
            'windDirection'    => $dto->getWindDirection(),
            'temperatureUnits' => $dto->getTemperatureUnits(),
            'windSpeed'        => $dto->getWindSpeed(),
            'humidity'         => $dto->getHumidity(),
        ]);
    }

}
