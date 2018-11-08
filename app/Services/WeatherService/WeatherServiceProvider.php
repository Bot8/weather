<?php

namespace App\Service\WeatherService;

use App\Service\WeatherService\Clients\OpenWeatherMapClient;
use App\Service\WeatherService\Clients\WeatherApiClient;
use App\Services\WeatherService\Exceptions\ApiClientException;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application;

class WeatherServiceProvider extends ServiceProvider
{
    /**
     * Регистрация сервиса экспорта погоды и клиента API
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(WeatherApiClient::class, function () {
            if (!$apiKey = config('weather.clients.openweathermap.api_key')) {
                throw new ApiClientException('No api_key provided for weather API client');
            }

            return new OpenWeatherMapClient($apiKey);
        });

        $this->app->singleton(WeatherExporterInterface::class, function (Application $app) {
            $exporter = new WeatherExporter(
                config('weather.export_path'),
                $app->make(WeatherApiClient::class)
            );

            foreach (config('weather.serializers') as $format => $serializer) {
                $exporter->addSerializer($format, $app->make($serializer));
            }

            return $exporter;
        });
    }
}