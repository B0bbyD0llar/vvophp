<?php declare(strict_types=1);

namespace VVOphp;

use DateTimeInterface;
use Exception;
use Psr\Log\LoggerInterface;
use VVOphp\Response\DepartureMonitorResponse;
use VVOphp\Response\PointFinderResponse;

/**
 * @url https://github.com/B0bbyD0llar/vvophp
 * @see https://github.com/kiliankoe/vvo
 */
final class VVOphp
{
    private Config $config;
    private ?LoggerInterface $logger;

    /**
     * @param Config $config
     * @param LoggerInterface|null $logger PSR-3 compatible Logger
     */
    public function __construct(Config $config, ?LoggerInterface $logger = null)
    {
        $this->config = $config;
        $this->logger = $logger;
    }

    private function getConfig(): Config
    {
        return $this->config;
    }

    public function getLogger(): ?LoggerInterface
    {
        return $this->logger;
    }

    /**
     * Searching needle for a point (e.g. station, street ...)
     *
     * @param string $needle
     * @param int|null $limit
     * @param bool|null $stopOnly
     * @return PointFinderResponse|null
     */
    public function searchPoint(string $needle, ?int $limit = null, ?bool $stopOnly = null): PointFinderResponse|null
    {
        try {
            $request = new Request($this->getConfig(), $this->getLogger());
            $request->setQueryURI($this->getConfig()->getPointFinderAPIURI());
            $finder = new PointFinder($request, $this->getLogger());
            $finder->setLimit($limit);
            $finder->setStopsOnly($stopOnly);
            return $finder->execQuery($needle);
        } catch (Exception) {
            return null;
        }
    }

    /**
     * @param int $id
     * @param DateTimeInterface|null $time
     * @param int|null $limit
     * @return DepartureMonitorResponse|null
     */
    public function getMonitorData(int $id, ?DateTimeInterface $time = null, ?int $limit = null): DepartureMonitorResponse|null
    {
        try {
            $request = new Request($this->getConfig(), $this->getLogger());
            $request->setQueryURI($this->getConfig()->getDepartureMonitorAPIURI());
            $monitor = new Monitor($request, $this->getLogger());
            $monitor->setLimit($limit);
            return $monitor->execQuery($id, $time);
        } catch (Exception) {
            return null;
        }
    }

}