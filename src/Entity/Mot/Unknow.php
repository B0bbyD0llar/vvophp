<?php declare(strict_types=1);

namespace VVOphp\Entity\Mot;

final class Unknow extends AbstractMot implements MotInterface
{
    public function __construct(string $rawName)
    {
        $this->setName('Unknow: ' . $rawName);
    }
}