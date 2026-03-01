<?php

declare(strict_types=1);

namespace VVOphp\Entity;

final class Diva
{
    private ?int $nummer;
    private ?string $network;

    public function getNummer(): ?int
    {
        return $this->nummer;
    }

    public function setNummer(?int $nummer): void
    {
        $this->nummer = $nummer;
    }

    public function getNetwork(): ?string
    {
        return $this->network;
    }

    public function setNetwork(?string $network): void
    {
        $this->network = $network;
    }
}
