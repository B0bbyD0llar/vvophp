<?php declare(strict_types=1);

namespace VVOphp;

use Psr\Log\LoggerInterface;
use VVOphp\Entity\Point\AbstractPoint;
use VVOphp\Entity\Point\Poi;
use VVOphp\Entity\Point\Stop;
use VVOphp\Entity\Point\Street;
use VVOphp\Response\PointFinderResponse;

final class PointFinder
{
    private const DEFAULT_LIMIT = 0;

    private Request $request;
    private ?LoggerInterface $logger;
    private string $query;
    private int $limit;
    private bool $stopsOnly = false;

    public function __construct(Request $request, ?LoggerInterface $logger = null)
    {
        $this->logger = $logger;
        $this->request = $request;
        $this->limit = self::DEFAULT_LIMIT;
    }

    private function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @param string $logText
     * @return void
     */
    private function logError(string $logText): void
    {
        if ($this->logger instanceof LoggerInterface) {
            $this->logger->error($logText);
        }
    }

    /**
     * @param string $query
     * @return PointFinderResponse|null
     */
    public function execQuery(string $query): ?PointFinderResponse
    {
        $this->query = $query;
        // assembly JSON body
        $queryBody['query'] = $this->getQuery();
        $queryBody['limit'] = $this->getLimit();
        $queryBody['stopsOnly'] = $this->isStopsOnly();

        // query server
        $this->getRequest()->setQueryBody($queryBody)->StartRequest();

        // Daten prüfen und entsprechen verarbeiten
        $data = json_decode($this->getRequest()->getResponseJSON(), false, 512, JSON_THROW_ON_ERROR);
        if ($data !== false) {
            $response = new PointFinderResponse();
            $response->setPointStatus($data->PointStatus);
            $response->setStatusCode($data->Status->Code);
            if (!empty($data->ExpirationTime)) {
                $response->setExpirationTime(Helper::getDateFromJSON($data->ExpirationTime));
            } else {
                $response->setExpirationTime(null);
            }
            foreach ($data->Points as $point) {
                $response->addPoint($this->processData($point));
            }
            return $response;
        }
        $this->logError('No result from API');
        return null;
    }

    private function processData(string $rawData): ?AbstractPoint
    {
        $point = null;
        $data = explode('|', $rawData);
        if (empty($data[1])) {
            $point = new Stop();
            $point->setRawData($data);
            $point->setId((int)$data[0]);
            $point->setName($data[3]);
            $point->setGK4X((int)$data[4]);
            $point->setGK4Y((int)$data[5]);
            if (!empty($data[2])) {
                $point->setCity($data[2]);
            } else {
                $point->setCity(null);
            }
        } elseif ($data[1] === 'a') {
            $point = new Street();
            $point->setRawData($data);
            $point->processDetailData($data[0]);
        } elseif ($data[1] === 'p') {
            xr($data);
            $point = new Poi();
            $point->setRawData($data);
            $point->processDetailData($data[0]);
        }
        return $point;
    }

    /**
     * @return string
     */
    public function getQuery(): string
    {
        return $this->query;
    }

    /**
     * @param string $query
     * @return PointFinder
     */
    public function setQuery(string $query): PointFinder
    {
        $this->query = $query;
        return $this;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param ?int $limit
     * @return PointFinder
     */
    public function setLimit(?int $limit): PointFinder
    {
        if ($limit !== null) {
            $this->limit = $limit;
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function isStopsOnly(): bool
    {
        return $this->stopsOnly;
    }

    /**
     * @param bool $stopsOnly
     * @return PointFinder
     */
    public function setStopsOnly(bool $stopsOnly): PointFinder
    {
        $this->stopsOnly = $stopsOnly;
        return $this;
    }

}