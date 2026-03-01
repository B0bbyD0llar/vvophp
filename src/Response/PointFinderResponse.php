<?php

declare(strict_types=1);

namespace VVOphp\Response;

use VVOphp\Entity\Point\PointInterface;

final class PointFinderResponse extends AbstractResponse implements ResponseInterface
{
    private string $pointStatus;

    /** @var array<PointInterface> */
    private ?array $points;

    public function getPointStatus(): string
    {
        return $this->pointStatus;
    }

    public function setPointStatus(string $pointStatus): void
    {
        $this->pointStatus = $pointStatus;
    }

    /**
     * @return null|array<PointInterface>
     */
    public function getPoints(): ?array
    {
        if (isset($this->points)) {
            return $this->points;
        }

        return null;
    }

    /**
     * @param null|array<PointInterface> $points
     */
    public function setPoints(?array $points): void
    {
        $this->points = $points;
    }

    public function addPoint(?PointInterface $point): void
    {
        if ($point !== null) {
            $this->points[] = $point;
        }
    }
}
