# VVOphp

[![PHP Version](https://img.shields.io/packagist/dependency-v/bitartist/vvophp/php)](https://packagist.org/packages/bitartist/vvophp)
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)
[![PHPStan Level 6](https://img.shields.io/badge/PHPStan-level%206-brightgreen.svg)](https://phpstan.org/)

A PHP library for accessing real-time public transport data from the [Verkehrsverbund Oberelbe (VVO)](https://www.vvo-online.de/de) network, including [Dresdner Verkehrsbetriebe (DVB)](https://www.dvb.de/de-de/).

> Inspired by [kiliankoe/vvo](https://github.com/kiliankoe/vvo)

## Features

- **Departure Monitor** -- Query real-time departures for any stop, including delays, platforms, and route changes
- **Point Finder** -- Search for stops, streets, and points of interest across the VVO network
- **10+ Transport Modes** -- Tram, CityBus, IntercityBus, Train, SuburbanRailway, Ferry, Cableway, and more
- **PSR-3 Logging** -- Optional logger integration for debugging
- **Proxy Support** -- Configurable HTTP proxy for API requests

## Requirements

- PHP 8.2+
- ext-curl

## Installation

```bash
composer require bitartist/vvophp
```

## Quick Start

### Search for a Stop

```php
use VVOphp\Config;
use VVOphp\VVOphp;

$vvo = new VVOphp(new Config());

// Search for stops matching "Hauptbahnhof"
$response = $vvo->searchPoint('Hauptbahnhof', limit: 5, stopOnly: true);

foreach ($response->getPoints() as $point) {
    echo $point->getName() . ' (ID: ' . $point->getId() . ')' . PHP_EOL;
}
```

### Get Departures

```php
use VVOphp\Config;
use VVOphp\VVOphp;

$vvo = new VVOphp(new Config());

// Get next departures for a stop (e.g. Postplatz = 33000037)
$response = $vvo->getMonitorData(33000037, limit: 10);

echo $response->getName() . ', ' . $response->getPlace() . PHP_EOL;

foreach ($response->getDepartures() as $departure) {
    echo sprintf(
        "Line %s -> %s (%s)\n",
        $departure->getLineName(),
        $departure->getDirection(),
        $departure->getScheduledTime()->format('H:i'),
    );
}
```

### With PSR-3 Logger

```php
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use VVOphp\Config;
use VVOphp\VVOphp;

$logger = new Logger('vvo');
$logger->pushHandler(new StreamHandler('php://stderr'));

$vvo = new VVOphp(new Config(), $logger);
```

### Proxy Configuration

```php
use VVOphp\Config;
use VVOphp\VVOphp;

$config = new Config();
$config->setProxyEnabled(true);
$config->setProxyHost('http://proxy.example.com:8080');

$vvo = new VVOphp($config);
```

## Development

### Prerequisites

- [Task](https://taskfile.dev/) (optional, for task automation)
- [Composer](https://getcomposer.org/)

### Setup

```bash
composer install
```

### Run All Checks

```bash
task
```

### Individual Tasks

```bash
task cs    # Code style (PHP CS Fixer + Composer Normalize)
task sca   # Static analysis (PHPStan level 6)
```

## Roadmap

- [ ] Trip queries and trip details
- [ ] Line information
- [ ] Route changes
- [ ] Test suite
- [ ] Extended documentation

## License

This project is licensed under the MIT License -- see the [LICENSE](LICENSE) file for details.