<?php declare(strict_types=1);

namespace VVOphp\Entity\Mot;

final class Cableway extends AbstractMot implements MotInterface
{
    public function __construct()
    {
        $this->setName('Cableway');
    }
}