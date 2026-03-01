<?php

declare(strict_types=1);

namespace VVOphp\Response;

abstract class AbstractResponse
{
    protected string $statusCode;
    protected ?\DateTimeInterface $expirationTime = null;

    public function getStatusCode(): string
    {
        return $this->statusCode;
    }

    public function setStatusCode(string $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    public function getExpirationTime(): ?\DateTimeInterface
    {
        return $this->expirationTime;
    }

    public function setExpirationTime(?\DateTimeInterface $expirationTime): void
    {
        $this->expirationTime = $expirationTime;
    }
}
