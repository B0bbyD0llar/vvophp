<?php

declare(strict_types=1);

namespace VVOphp;

use Psr\Log\LoggerInterface;
use VVOphp\Entity\Departure;
use VVOphp\Response\DepartureMonitorResponse;

final class Monitor
{
    private const int DEFAULT_LIMIT = 5;
    private Request $request;
    private ?LoggerInterface $logger;
    private int $stopId;
    private int $limit;
    private bool $shorttermchanges = true;
    private bool $isarrival = false;
    private ?\DateTimeInterface $time;

    public function __construct(Request $request, ?LoggerInterface $logger = null)
    {
        $this->logger = $logger;
        $this->request = $request;
        $this->limit = self::DEFAULT_LIMIT;
        $this->time = null;
    }

    private function getRequest(): Request
    {
        return $this->request;
    }

    private function logError(string $logText): void
    {
        if ($this->logger instanceof LoggerInterface) {
            $this->logger->error($logText);
        }
    }

    /**
     * @throws \JsonException
     */
    public function execQuery(int $stopId, ?\DateTimeInterface $time = null): ?DepartureMonitorResponse
    {
        $this->setStopId($stopId);
        $this->setTime($time);
        $queryBody['stopid'] = $this->getStopId();
        $queryBody['limit'] = $this->getLimit();

        if (!empty($this->getTime())) {
            $queryBody['time'] = $this->getTime();
        }

        $queryBody['shorttermchanges'] = $this->isShorttermchanges();

        if ($this->getRequest()->setQueryBody($queryBody)->StartRequest()) {
            $data = json_decode($this->getRequest()->getResponseJSON(), false, 512, JSON_THROW_ON_ERROR);

            if ($data !== null) {
                $response = new DepartureMonitorResponse();
                $response->setStatusCode($data->Status->Code);
                $response->setTime($time ?? new \DateTime());
                $response->setName($data->Name);
                $response->setPlace($data->Place);

                if (isset($data->ExpirationTime)) {
                    $response->setExpirationTime(Helper::getDateFromJSON($data->ExpirationTime));
                }

                if (isset($data->Departures)) {
                    foreach ($data->Departures as $depart) {
                        $dp = new Departure();
                        $dp->getFromJSON($depart);
                        $response->addDeparture($dp);
                    }
                } else {
                    $response->setDepartures([]);
                }

                return $response;
            }
        }

        $this->logError('No result from API');

        return null;
    }

    public function getStopId(): int
    {
        return $this->stopId;
    }

    public function setStopId(int $stopId): void
    {
        $this->stopId = $stopId;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function setLimit(?int $limit): self
    {
        if ($limit !== null) {
            $this->limit = $limit;
        }

        return $this;
    }

    public function isShorttermchanges(): bool
    {
        return $this->shorttermchanges;
    }

    public function setShorttermchanges(bool $shorttermchanges): self
    {
        $this->shorttermchanges = $shorttermchanges;

        return $this;
    }

    public function getIsarrival(): bool
    {
        return $this->isarrival;
    }

    public function setIsarrival(bool $isarrival): void
    {
        $this->isarrival = $isarrival;
    }

    /**
     * DATE_ATOM formated string.
     */
    private function getTime(): ?string
    {
        if ($this->time instanceof \DateTimeInterface) {
            return $this->time->format(DATE_ATOM);
        }

        return null;
    }

    public function setTime(?\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }
}
