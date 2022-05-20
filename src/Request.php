<?php declare(strict_types=1);

namespace VVOphp;

use JsonException;
use Psr\Log\LoggerInterface;
use RuntimeException;

final class Request
{
    private string $queryURI;
    /** @var array<string, bool|int|string> $queryBody */
    private array $queryBody;

    private bool|string $responseJSON;
    private bool|int $responseStatusCode; // HTTP-Status-Code
    private int $responseErrorNo;
    private string $responseErrorText;

    private Config $config;
    private ?LoggerInterface $logger;

    public function __construct(Config $config, ?LoggerInterface $logger = null)
    {
        $this->logger = $logger;
        $this->config = $config;
    }

    /**
     * @return bool
     * @throws JsonException
     */
    public function StartRequest(): bool
    {
        // Pre-checks
        if (empty($this->getQueryURI())) {
            $this->logError('Error: no URI defined!');
            throw new RuntimeException('Error: no URI defined!');
        }
        if (empty($this->getQueryBody())) {
            $this->logError('Error: no JSON object defined!');
            throw new RuntimeException('Error: no JSON object defined!');
        }

        $curl = curl_init($this->getQueryURI());
        if ($this->config->isProxyEnabled()) {
            curl_setopt($curl, CURLOPT_PROXY, $this->config->getProxyHost());
        }
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->getQueryBody());
        $this->setResponseJSON(curl_exec($curl));
        $this->setResponseStatusCode(curl_getinfo($curl, CURLINFO_HTTP_CODE));
        $ret = $this->getResponseStatusCode();
        if ($ret !== 201 && $ret !== 200) {
            $this->setResponseErrorText(curl_error($curl));
            $this->setResponseErrorNo(curl_errno($curl));
            curl_close($curl);
            $this->logError(sprintf('Error: call to URL %s failed with status %s', $this->getQueryURI(), $this->getResponseStatusCode()));
            $this->logError($this->getResponseErrorNo() . ' ' . $this->getResponseErrorText());
            return false;
        }
        curl_close($curl);
        return true;
    }

    /**
     * @param string $logText
     * @return void
     */
    private function logError(string $logText): void
    {
        if ($this->logger instanceof LoggerInterface) {
            $this->logger->error($logText);
        }
    }

    /**
     * @return string
     */
    public function getQueryURI(): string
    {
        return $this->queryURI;
    }

    /**
     * @param string $queryURI
     * @return Request
     */
    public function setQueryURI(string $queryURI): Request
    {
        $this->queryURI = $queryURI;
        return $this;
    }

    /**
     * @return string
     * @throws JsonException
     */
    public function getQueryBody(): string
    {
        return json_encode($this->queryBody, JSON_THROW_ON_ERROR);
    }

    /**
     * @param array<string, bool|int|string> $queryBody
     * @return Request
     */
    public function setQueryBody(array $queryBody): Request
    {
        $this->queryBody = $queryBody;
        return $this;
    }

    /**
     * @return bool|int
     */
    public function getResponseStatusCode(): bool|int
    {
        return $this->responseStatusCode;
    }

    /**
     * @param bool|int $responseStatusCode
     * @return Request
     */
    public function setResponseStatusCode(bool|int $responseStatusCode): Request
    {
        $this->responseStatusCode = $responseStatusCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getResponseJSON(): string
    {
        return $this->responseJSON;
    }

    /**
     * @param bool|string $responseJSON
     * @return Request
     */
    public function setResponseJSON(bool|string $responseJSON): Request
    {
        $this->responseJSON = $responseJSON;
        return $this;
    }

    /**
     * @return int
     */
    public function getResponseErrorNo(): int
    {
        return $this->responseErrorNo;
    }

    /**
     * @param int $responseErrorNo
     */
    private function setResponseErrorNo(int $responseErrorNo): void
    {
        $this->responseErrorNo = $responseErrorNo;
    }

    /**
     * @return string
     */
    public function getResponseErrorText(): string
    {
        return $this->responseErrorText;
    }

    /**
     * @param string $responseErrorText
     */
    private function setResponseErrorText(string $responseErrorText): void
    {
        $this->responseErrorText = $responseErrorText;
    }

}