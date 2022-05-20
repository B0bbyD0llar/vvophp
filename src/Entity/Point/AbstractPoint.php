<?php declare(strict_types=1);

namespace VVOphp\Entity\Point;

abstract class AbstractPoint implements PointInterface
{
    private int $id;
    private string $name;
    private ?string $city;
    /** @var array<mixed> $rawData */
    protected array $rawData = [];

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return ?string
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param ?string $city
     */
    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return array<mixed>
     */
    public function getRawData(): array
    {
        return $this->rawData;
    }

    /**
     * @param array<mixed> $rawData
     */
    public function setRawData(array $rawData): void
    {
        $this->rawData = $rawData;
    }

}