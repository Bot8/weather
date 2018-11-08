<?php

namespace App\Service\WeatherService;

use App\Service\WeatherService\Clients\WeatherApiClient;
use App\Service\WeatherService\Exceptions\InvalidFormatException;
use App\Service\WeatherService\Serializer\SerializerInterface;

/**
 * Class WeatherExporter
 * @package App\Services\WeatherService
 */
class WeatherExporter implements WeatherExporterInterface
{
    /** @var WeatherApiClient */
    protected $apiClient;

    /** @var array */
    protected $serializers = [];

    /** @var string */
    protected $exportPath;

    /**
     * WeatherExporter constructor.
     *
     * @param string           $exportPath
     * @param WeatherApiClient $apiClient
     */
    public function __construct(string $exportPath, WeatherApiClient $apiClient)
    {
        $this->exportPath = $exportPath;
        $this->apiClient = $apiClient;
    }

    /** @inheritdoc */
    public function addSerializer(string $format, SerializerInterface $serializer): WeatherExporterInterface
    {
        $this->serializers[$format] = $serializer;

        return $this;
    }

    /** @inheritdoc */
    public function exportWeather(string $format, string $city): string
    {
        $file = $this->exportPath . '/' . $this->getSerializer($format)->getFileName($city);

        file_put_contents($file, $this->getWeather($format, $city));

        return $file;
    }

    /** @inheritdoc */
    public function getWeather(string $format, string $city): ?string
    {
        $serializer = $this->getSerializer($format);

        return $serializer->serialize(
            $this->apiClient->getWeather($city)
        );
    }

    /**
     * @param string $format Формат экспорта
     *
     * @return SerializerInterface
     * @throws InvalidFormatException
     */
    protected function getSerializer(string $format): SerializerInterface
    {
        if (!isset($this->serializers[$format])) {
            throw new InvalidFormatException("Invalid format '{$format}', available: " . implode(',', array_keys($this->serializers)));
        }

        return $this->serializers[$format];
    }
}