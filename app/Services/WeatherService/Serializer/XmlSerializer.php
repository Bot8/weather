<?php

namespace App\Services\WeatherService\Serializer;

use App\Service\WeatherService\Serializer\SerializerInterface;
use App\Service\WeatherService\WeatherDTO;

class XmlSerializer implements SerializerInterface
{
    /** @inheritdoc */
    public function getFileName(string $name): string
    {
        return "{$name}.xml";
    }
    
    /** @inheritdoc */
    public function serialize(WeatherDTO $dto): string
    {
        $date = $dto->getDate();

        $xml_header = '<?xml version="1.0" encoding="UTF-8"?><Weather></Weather>';
        $xml = new \SimpleXMLElement($xml_header);

        $xml->addChild('windSpeed', $dto->getWindSpeed());
        $xml->addChild('temperature', $dto->getTemperature());
        $xml->addChild('date', $date ? $date->getTimestamp() : null);
        $xml->addChild('windDirection', $dto->getWindDirection());
        $xml->addChild('temperatureUnits', $dto->getTemperatureUnits());
        $xml->addChild('humidity', $dto->getHumidity());

        return $xml->asXML();
    }
}
