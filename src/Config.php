<?php

declare(strict_types=1);

namespace VVOphp;

final class Config
{
    private string $pointFinder_API_URI;
    private string $departureMonitor_API_URI;
    private bool $proxyEnabled;
    private ?string $proxyHost;

    public function __construct()
    {
        // setup default values
        $this->setPointFinderAPIURI('https://webapi.vvo-online.de/tr/pointfinder');
        $this->setDepartureMonitorAPIURI('https://webapi.vvo-online.de/dm');
        $this->proxyEnabled = false;
        $this->proxyHost = null;
    }

    public function getPointFinderAPIURI(): string
    {
        return $this->pointFinder_API_URI;
    }

    public function setPointFinderAPIURI(string $pointFinder_API_URI): void
    {
        $this->pointFinder_API_URI = $pointFinder_API_URI;
    }

    public function getDepartureMonitorAPIURI(): string
    {
        return $this->departureMonitor_API_URI;
    }

    public function setDepartureMonitorAPIURI(string $departureMonitor_API_URI): void
    {
        $this->departureMonitor_API_URI = $departureMonitor_API_URI;
    }

    public function isProxyEnabled(): bool
    {
        return $this->proxyEnabled;
    }

    public function setProxyEnabled(bool $proxyEnabled): void
    {
        $this->proxyEnabled = $proxyEnabled;
    }

    public function getProxyHost(): ?string
    {
        return $this->proxyHost;
    }

    public function setProxyHost(?string $proxyHost): void
    {
        $this->proxyHost = $proxyHost;
    }
}
