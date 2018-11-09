## Установка
- Выполнить команду `composer install`
- Скопировать `.env.example` в `.env`
- В `.env` заполнить `OPENWEATHERMAP_API_KEY`


## Запуск
`php artisan weather:export <format> [<city>]`

где
- `format` - формат экспорта (xml, json)
- `city` - город для которого запрашивается погода (default: "Sevastopol")


