<?php

namespace App\Service\WeatherService;

use App\Service\WeatherService\Serializer\SerializerInterface;

interface WeatherExporterInterface
{
    /**
     * @param string              $format     Формат экспорта
     * @param SerializerInterface $serializer Сериализатор
     *
     * @return WeatherExporterInterface
     */
    public function addSerializer(string $format, SerializerInterface $serializer): WeatherExporterInterface;

    /**
     * Экспорт погоды в фаил
     *
     * @param string $format Формат экспорта
     * @param string $city   Город
     *
     * @return null|string Путь к файлу экспорта
     */
    public function exportWeather(string $format, string $city): ?string;

    /**
     * Получение экспорта в текстовом формате
     *
     * @param string $format Формат экспорта
     * @param string $city   Город
     *
     * @return null|string СОдержимое экспорта
     */
    public function getWeather(string $format, string $city): ?string;
}
