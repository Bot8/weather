<?php

namespace App\Service\WeatherService\Clients;

use App\Service\WeatherService\WeatherDTO;
use App\Services\WeatherService\Exceptions\ApiClientException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;

class OpenWeatherMapClient implements WeatherApiClient
{
    protected const API_ROOT = 'http://api.openweathermap.org/data/2.5';

    /** @var string */
    protected $key;

    /** @var Client */
    protected $client;

    /**
     * OpenWeatherMapClient constructor.
     *
     * @param $key
     */
    public function __construct(string $key)
    {
        $this->key = $key;
        $this->client = new Client();
    }

    /** @inheritdoc */
    public function getWeather(string $city, string $format = self::METRIC_UNITS): WeatherDTO
    {
        if (!isset(self::TEMPERATURE_UNITS[$format])) {
            throw new ApiClientException("Invalid format {$format}, available: " . implode(',', array_keys(self::TEMPERATURE_UNITS)));
        }

        try {
            $response = $this->request('weather', [
                'q'     => $city,
                'units' => $format,
            ]);
        } catch (\Exception $e) {
            throw new ApiClientException($e->getMessage(), $e->getCode(), $e);
        }

        if (!$response) {
            throw new ApiClientException('Empty Api response');
        }

        return $this->transformResponse($response, $format);
    }

    /**
     * Запрос к API
     *
     * @param string $endpoint API endpoint
     * @param array  $data     Параметры запроса
     *
     * @return array
     */
    protected function request(string $endpoint, array $data): array
    {
        $query = $this->buildQuery($data);

        try {
            $response = $this->client->get(self::API_ROOT . "/{$endpoint}?{$query}");
        } catch (ClientException $e) {
            throw new ApiClientException($this->parseApiException($e), $e->getCode());
        }

        return $this->parseApiResponse($response);
    }

    /**
     * Преобразование массива данных в строку запроса и
     * добавление дополнительных параметров в запрос
     *
     * @param array $data
     *
     * @return string
     */
    protected function buildQuery(array $data): string
    {
        $data['APPID'] = $this->key;

        return http_build_query($data);
    }

    /**
     * Преобразование ответа api в массив
     *
     * @param ResponseInterface $response
     *
     * @return array
     */
    protected function parseApiResponse(ResponseInterface $response): array
    {
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Преобразование ответа API в DTO
     *
     * @param array  $response Ответ API
     * @param string $format   Формат возвращаемых данных
     *
     * @return WeatherDTO
     */
    protected function transformResponse(array $response, string $format): WeatherDTO
    {
        return (new WeatherDTO())
            ->setDate(new \DateTime())
            ->setHumidity($response['main']['humidity'] ?? null)
            ->setTemperature($response['main']['temp'] ?? null)
            ->setTemperatureUnits(self::TEMPERATURE_UNITS[$format])
            ->setWindDirection($response['wind']['deg'] ?? null)
            ->setWindSpeed($response['wind']['speed'] ?? null);
    }

    /**
     * Получение строки ошибки
     *
     * @param ClientException $e
     *
     * @return string
     */
    protected function parseApiException(ClientException $e): string
    {
        if (!$response = $e->getResponse()) {
            return 'Undefined exception. Code: ' . $e->getCode();
        }

        if (($content = $this->parseApiResponse($response)) && $content['message']) {
            return $content['message'];
        }

        return $response->getReasonPhrase();
    }
}