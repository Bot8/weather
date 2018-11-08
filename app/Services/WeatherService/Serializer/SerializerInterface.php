<?php

namespace App\Service\WeatherService\Serializer;

use App\Service\WeatherService\WeatherDTO;

interface SerializerInterface
{
    /**
     * @param string $name Имя файла
     *
     * @return string Имя фаила для экспорта
     */
    public function getFileName(string $name): string;

    /**
     * @param WeatherDTO $dto
     *
     * @return string Сериализованное DTO
     */
    public function serialize(WeatherDTO $dto): string;
}