<?php

namespace App\Service\WeatherService;

class WeatherDTO
{
    /** @var float */
    protected $temperature;

    /** @var string */
    protected $temperatureUnits;

    /** @var \DateTime */
    protected $date;

    /** @var string */
    protected $windDirection;

    /** @var float */
    protected $windSpeed;

    /** @var float */
    protected $humidity;

    /**
     * @return float
     */
    public function getTemperature(): ?float
    {
        return $this->temperature;
    }

    /**
     * @param float $temperature
     *
     * @return self
     */
    public function setTemperature(?float $temperature): self
    {
        $this->temperature = $temperature;

        return $this;
    }

    /**
     * @return string
     */
    public function getTemperatureUnits(): ?string
    {
        return $this->temperatureUnits;
    }

    /**
     * @param string $temperatureUnits
     *
     * @return self
     */
    public function setTemperatureUnits(?string $temperatureUnits): self
    {
        $this->temperatureUnits = $temperatureUnits;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     *
     * @return self
     */
    public function setDate(\DateTime $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return string
     */
    public function getWindDirection(): ?string
    {
        return $this->windDirection;
    }

    /**
     * @param string $windDirection
     *
     * @return self
     */
    public function setWindDirection(?string $windDirection): self
    {
        $this->windDirection = $windDirection;

        return $this;
    }

    /**
     * @return float
     */
    public function getWindSpeed(): ?float
    {
        return $this->windSpeed;
    }

    /**
     * @param float $windSpeed
     *
     * @return self
     */
    public function setWindSpeed(?float $windSpeed): self
    {
        $this->windSpeed = $windSpeed;

        return $this;
    }

    /**
     * @return float
     */
    public function getHumidity(): ?float
    {
        return $this->humidity;
    }

    /**
     * @param float $humidity
     *
     * @return self
     */
    public function setHumidity(?float $humidity): self
    {
        $this->humidity = $humidity;

        return $this;
    }
}
