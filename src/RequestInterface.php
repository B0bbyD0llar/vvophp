<?php

declare(strict_types=1);

namespace VVOphp;

interface RequestInterface
{
    /**
     * @throws \JsonException
     */
    public function StartRequest(): bool;

    public function getQueryURI(): string;

    public function setQueryURI(string $queryURI): self;

    /**
     * @throws \JsonException
     */
    public function getQueryBody(): string;

    /**
     * @param array<string, bool|int|string> $queryBody
     */
    public function setQueryBody(array $queryBody): self;

    public function getResponseJSON(): string;

    public function setResponseJSON(bool|string $responseJSON): self;

    public function getResponseStatusCode(): bool|int;

    public function setResponseStatusCode(bool|int $responseStatusCode): self;
}
