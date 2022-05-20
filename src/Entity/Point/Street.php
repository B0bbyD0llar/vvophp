<?php declare(strict_types=1);

namespace VVOphp\Entity\Point;

final class Street extends AbstractPoint
{
    private ?string $plz;

    /**
     * @see https://github.com/kiliankoe/vvo/blob/main/documentation/webapi.md
     * @param string $data
     * @return void
     */
    public function processDetailData(string $data): void
    {
        $rawData = explode(':', $data);
        $this->rawData[0] = $rawData;
        $this->setId((int)$rawData[1]);
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

    /**
     * @return ?string
     */
    public function getPlz(): ?string
    {
        return $this->plz;
    }

    /**
     * @param ?string $plz
     * @return Street
     */
    public function setPlz(?string $plz): Street
    {
        $this->plz = $plz;
        return $this;
    }

}