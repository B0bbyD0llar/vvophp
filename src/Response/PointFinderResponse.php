<?php declare(strict_types=1);

namespace VVOphp\Response;

use VVOphp\Entity\Point\PointInterface;

final class PointFinderResponse extends AbstractResponse implements ResponseInterface
{
    private string $pointStatus;
    /** @var PointInterface[] $points */
    private ?array $points;


    /**
     * @return string
     */
    public function getPointStatus(): string
    {
        return $this->pointStatus;
    }

    /**
     * @param string $pointStatus
     */
    public function setPointStatus(string $pointStatus): void
    {
        $this->pointStatus = $pointStatus;
    }


    /**
     * @return PointInterface[]|null
     */
    public function getPoints(): array|null
    {
        if (isset($this->points)) {
            return $this->points;
        }
        return null;
    }

    /**
     * @param PointInterface[]|null $points
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