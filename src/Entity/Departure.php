<?php

declare(strict_types=1);

namespace VVOphp\Entity;

use VVOphp\Entity\Mot\Cableway;
use VVOphp\Entity\Mot\CityBus;
use VVOphp\Entity\Mot\Ferry;
use VVOphp\Entity\Mot\HailedSharedTaxi;
use VVOphp\Entity\Mot\IntercityBus;
use VVOphp\Entity\Mot\MotInterface;
use VVOphp\Entity\Mot\PlusBus;
use VVOphp\Entity\Mot\SuburbanRailway;
use VVOphp\Entity\Mot\Train;
use VVOphp\Entity\Mot\Tram;
use VVOphp\Entity\Mot\Unknow;
use VVOphp\Helper;

final class Departure
{
    private int $id;
    private string $lineName;
    private string $direction;
    private ?Platform $platform = null;
    private MotInterface $mot;
    private ?\DateTimeInterface $RealTime = null;
    private ?\DateTimeInterface $ScheduledTime = null;
    private ?string $state = null;

    /** @var null|array<mixed> */
    private ?array $routeChanges = null;
    private ?Diva $diva = null;

    public function getFromJSON(object $jsonObject): void
    {
        $idData = explode(':', $jsonObject->Id);
        $this->setId((int) $idData[1]);
        $this->setLineName($jsonObject->LineName);
        $this->setDirection($jsonObject->Direction);
        $mot = match ($jsonObject->Mot) {
            'CityBus' => new CityBus(),
            'Tram' => new Tram(),
            'IntercityBus' => new IntercityBus(),
            'SuburbanRailway' => new SuburbanRailway(),
            'Train' => new Train(),
            'PlusBus' => new PlusBus(),
            'Cableway' => new Cableway(),
            'Ferry' => new Ferry(),
            'HailedSharedTaxi' => new HailedSharedTaxi(),
            default => new Unknow($jsonObject->Mot),
        };
        $this->setMot($mot);

        if (!empty($jsonObject->Platform)) {
            $platform = new Platform();
            $platform->setName($jsonObject->Platform->Name);
            $platform->setType($jsonObject->Platform->Type);
            $this->setPlatform($platform);
        } else {
            $this->setPlatform(null);
        }

        if (!empty($jsonObject->Diva)) {
            $diva = new Diva();
            $diva->setNummer((int) $jsonObject->Diva->Number);
            $diva->setNetwork($jsonObject->Diva->Network);
            $this->setDiva($diva);
        } else {
            $this->setDiva(null);
        }

        if (!empty($jsonObject->State)) {
            $this->setState($jsonObject->State);
        }

        if (!empty($jsonObject->RouteChanges)) {
            $this->setRouteChanges($jsonObject->RouteChanges);
        }

        if (!empty($jsonObject->RealTime)) {
            $this->setRealTime(Helper::getDateFromJSON($jsonObject->RealTime));
        }

        $this->setScheduledTime(Helper::getDateFromJSON($jsonObject->ScheduledTime));
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getLineName(): string
    {
        return $this->lineName;
    }

    public function setLineName(string $lineName): void
    {
        $this->lineName = $lineName;
    }

    /**
     * @return mixed
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * @param string $direction
     */
    public function setDirection($direction): void
    {
        $this->direction = $direction;
    }

    public function getPlatform(): ?Platform
    {
        return $this->platform;
    }

    public function setPlatform(?Platform $platform): void
    {
        $this->platform = $platform;
    }

    /**
     * @return mixed
     */
    public function getMot()
    {
        return $this->mot;
    }

    /**
     * @param mixed $mot
     */
    public function setMot($mot): self
    {
        $this->mot = $mot;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRealTime()
    {
        return $this->RealTime;
    }

    /**
     * @param mixed $RealTime
     */
    public function setRealTime($RealTime): self
    {
        $this->RealTime = $RealTime;

        return $this;
    }

    public function getScheduledTime(): ?\DateTimeInterface
    {
        return $this->ScheduledTime;
    }

    public function setScheduledTime(\DateTimeInterface $ScheduledTime): self
    {
        $this->ScheduledTime = $ScheduledTime;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): void
    {
        $this->state = $state;
    }

    /**
     * @return null|array<mixed>
     */
    public function getRouteChanges(): ?array
    {
        return $this->routeChanges;
    }

    /**
     * @param null|array<mixed> $routeChanges
     */
    public function setRouteChanges(?array $routeChanges): void
    {
        $this->routeChanges = $routeChanges;
    }

    /**
     * @return null|Diva
     */
    public function getDiva()
    {
        return $this->diva;
    }

    public function setDiva(?Diva $diva): void
    {
        $this->diva = $diva;
    }

    public function getDelay(): void
    {
        if ($this->getState() != 'Delayed') {
            return;
        }

        if (!\is_object($this->getScheduledTime()) || !\is_object($this->getRealTime())) {
            return;
        }

        echo $this->getScheduledTime()->diff($this->getRealTime())->format('%R%i m');
    }
}
