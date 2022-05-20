<?php declare(strict_types=1);

namespace VVOphp\Entity\Point;

final class Poi extends AbstractPoint
{
    public function processDetailData(string $data): void
    {
        $rawData = explode(':', $data);
        $this->rawData[0] = $rawData;
        $this->setId((int)$rawData[1]);
        $this->setName($rawData[4]);
        if (!empty($rawData[5])) {
            $this->setCity($rawData[5]);
        }
    }

}