<?php declare(strict_types=1);

namespace VVOphp\Entity\Mot;

final class Ferry extends AbstractMot implements MotInterface
{
    public function __construct()
    {
        $this->setName('Ferry');
    }
}