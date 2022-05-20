<?php declare(strict_types=1);

namespace VVOphp\Response;

use DateTimeInterface;

abstract class AbstractResponse
{
    protected string $statusCode;
    protected ?DateTimeInterface $expirationTime;

    /**
     * @return string
     */
    public function getStatusCode(): string
    {
        return $this->statusCode;
    }

    /**
     * @param string $statusCode
     */
    public function setStatusCode(string $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @return ?DateTimeInterface
     */
    public function getExpirationTime(): DateTimeInterface|null
    {
        return $this->expirationTime;
    }

    /**
     * @param ?DateTimeInterface $expirationTime
     */
    public function setExpirationTime(DateTimeInterface|null $expirationTime): void
    {
        $this->expirationTime = $expirationTime;
    }

}