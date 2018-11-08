<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Service\WeatherService\WeatherExporterInterface;

/**
 * Class ExportWeatherCommand
 * @package App\Console\Commands
 */
class ExportWeatherCommand extends Command
{
    /**
     * @inheritdoc
     */
    protected $signature = 'weather:export {format} {city=Sevastopol}';

    /**
     * @inheritdoc
     */
    protected $description = 'Exports current weather in the chosen format';

    /** @var WeatherExporterInterface */
    protected $exporter;

    /**
     * ExportWeatherCommand constructor.
     *
     * @param WeatherExporterInterface $exporter
     */
    public function __construct(WeatherExporterInterface $exporter)
    {
        parent::__construct();

        $this->exporter = $exporter;
    }

    public function handle()
    {
        $this->line('Start weather export');

        try {
            $exportTo = $this->exporter->exportWeather(
                $this->argument('format'),
                $this->argument('city')
            );
        } catch (\Exception $e) {
            $this->error($e->getMessage());

            return $e->getCode();
        }

        $this->line("Weather export finished to {$exportTo}");

        return 0;
    }
}
