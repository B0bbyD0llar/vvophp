<?php declare(strict_types=1);

namespace VVOphp\Response;

use DateTimeInterface;
use VVOphp\Entity\Departure;

final class DepartureMonitorResponse extends AbstractResponse implements ResponseInterface
{
    private string $name;
    private string $place;
    /** @var Departure[]|null $departures */
    private ?array $departures;
    private ?DateTimeInterface $time;
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPlace(): string
    {
        return $this->place;
    }

    /**
     * @param string $place
     */
    public function setPlace(string $place): void
    {
        $this->place = $place;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getTime(): ?DateTimeInterface
    {
        return $this->time;
    }

    /**
     * @param DateTimeInterface|null $time
     */
    public function setTime(?DateTimeInterface $time): void
    {
        $this->time = $time;
    }
    
    /**
     * @return Departure[]|null
     */
    public function getDepartures(): array|null
    {
        return $this->departures;
    }

    /**
     * @param Departure[]|null $departures
     */
    public function setDepartures(?array $departures): void
    {
        $this->departures = $departures;
    }

    public function addDeparture(Departure $departure): void
    {
        $this->departures[] = $departure;
    }

}