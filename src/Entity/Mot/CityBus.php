<?php declare(strict_types=1);

namespace VVOphp\Entity\Mot;

final class CityBus extends AbstractMot implements MotInterface
{
    public function __construct()
    {
        $this->setName('CityBus');
    }
}