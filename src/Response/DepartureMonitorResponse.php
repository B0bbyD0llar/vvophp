<?php

declare(strict_types=1);

namespace VVOphp\Response;

use VVOphp\Entity\Departure;

final class DepartureMonitorResponse extends AbstractResponse implements ResponseInterface
{
    private string $name;
    private string $place;

    /** @var null|array<Departure> */
    private ?array $departures = null;
    private ?\DateTimeInterface $time;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPlace(): string
    {
        return $this->place;
    }

    public function setPlace(string $place): void
    {
        $this->place = $place;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(?\DateTimeInterface $time): void
    {
        $this->time = $time;
    }

    /**
     * @return null|array<Departure>
     */
    public function getDepartures(): ?array
    {
        return $this->departures;
    }

    /**
     * @param null|array<Departure> $departures
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
