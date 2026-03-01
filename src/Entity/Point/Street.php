<?php

declare(strict_types=1);

namespace VVOphp\Entity\Point;

final class Street extends AbstractPoint
{
    private ?string $plz;

    /**
     * @see https://github.com/kiliankoe/vvo/blob/main/documentation/webapi.md
     */
    public function processDetailData(string $data): void
    {
        $rawData = explode(':', $data);
        $this->rawData[0] = $rawData;
        $this->setId((int) $rawData[1]);
        $this->setName($rawData[5]);

        if (!empty($rawData[10])) {
            $this->setPlz($rawData[10]);
        } else {
            $this->setPlz(null);
        }

        if (!empty($rawData[6])) {
            $this->setCity($rawData[6]);
        }
    }

    public function getPlz(): ?string
    {
        return $this->plz;
    }

    public function setPlz(?string $plz): self
    {
        $this->plz = $plz;

        return $this;
    }
}
