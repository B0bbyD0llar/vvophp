<?php declare(strict_types=1);

namespace VVOphp\Entity\Point;

final class Stop extends AbstractPoint
{
    /**
     *  Array-Index-List (actually only user Index 0,3,6 & 10)
     *    Index Type            Description                                                   Always included
     *    0     Int or string   ID of a stop (int), or an other type (string, see below)        Yes
     *    1     String          Unknown.                                                        No
     *    2     String          City name if point is not in the VVO area                       No
     *    3     String          Name of the stop or street                                      Yes
     *    4     Int             Right part of the GK4 coordinates                               Yes
     *    5     Int             Up part of the GK4 coordinates                                  Yes
     *    6     Int             Distance, when submitting coords in query otherwise 0           Yes
     *    7     ???             Unknown.                                                        No
     *    8     String          Shortcut of the stop                                            No
     */
    private int $GK4_x;
    private int $GK4_y;

    /**
     * @return int
     */
    public function getGK4X(): int
    {
        return $this->GK4_x;
    }

    /**
     * @param int $GK4_x
     */
    public function setGK4X(int $GK4_x): void
    {
        $this->GK4_x = $GK4_x;
    }

    /**
     * @return int
     */
    public function getGK4Y(): int
    {
        return $this->GK4_y;
    }

    /**
     * @param int $GK4_y
     */
    public function setGK4Y(int $GK4_y): void
    {
        $this->GK4_y = $GK4_y;
    }

}