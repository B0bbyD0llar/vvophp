<?php

declare(strict_types=1);

namespace VVOphp\Entity\Mot;

abstract class AbstractMot
{
    private string $name;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
