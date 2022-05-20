<?php declare(strict_types=1);

namespace VVOphp\Entity;

final class Diva
{
    private ?int $nummer;
    private ?string $network;

    /**
     * @return int|null
     */
    public function getNummer(): ?int
    {
        return $this->nummer;
    }

    /**
     * @param int|null $nummer
     */
    public function setNummer(?int $nummer): void
    {
        $this->nummer = $nummer;
    }

    /**
     * @return string|null
     */
    public function getNetwork(): ?string
    {
        return $this->network;
    }

    /**
     * @param string|null $network
     */
    public function setNetwork(?string $network): void
    {
        $this->network = $network;
    }

}