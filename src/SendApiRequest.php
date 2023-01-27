<?php

namespace Extrovert\TestTask1;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class SendApiRequest
{
    /**
     * Params that will be included in every request.
     * @var array
     */
    public array $defaultParams = [];
    /**
     * Type of request params.
     * @var string
     */
    public string $paramsType = 'form_params';
    /**
     * Options of request. Check GuzzleHTTP Client->request method.
     * @var array
     */
    public array $requestOptions = [];
    /**
     * Received response will be here.
     * @var Response|null
     */
    public ?Response $response = null;

    protected string $entryUrl;

    protected Client $client;

    protected string $methodName;
    protected string $requestUrl;

    protected array $params = [];
    protected string $asFormParamsType = 'form_params';
    protected string $asMultipartParamsType = 'multipart';

    public function __construct($entryUrl)
    {
        $this->setEntryUrl($entryUrl);

        $this->client = new Client();
    }

    /**
     * Set request type as Form.
     * @return $this
     */
    public function asForm(): self
    {
        $this->paramsType = $this->asFormParamsType;

        return $this;
    }

    /**
     * Set request type as Multipart.
     * @return $this
     */
    public function asMultipart(): self
    {
        $this->paramsType = $this->asMultipartParamsType;

        return $this;
    }

    /**
     * Set method name. (WITHOUT .json)
     * @param string $method
     * @return $this
     */
    public function method(string $method): self{
        $this->methodName = rtrim($method, '.') . '.json';

        return $this;
    }

    /**
     * Send request.
     * @param array $params
     * @return false|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send(array $params = [])
    {
        $this->setParams($params);
        $this->genRequestUrl();
        $this->prepareRequestOptions();

        $this->response = $this->client->request('POST', $this->requestUrl, $this->requestOptions);

        return $this->getContent();
    }

    protected function setParams(array $params){
        $this->params = array_merge($this->defaultParams, $params);
    }

    protected function prepareRequestOptions()
    {
        switch ($this->paramsType) {
            case $this->asMultipartParamsType:
                $this->requestOptions[$this->asMultipartParamsType] = $this->genParamsMultipart();
                break;
            default:
                $this->requestOptions[$this->asFormParamsType] = $this->genParamsForm();
                break;
        }
    }

    protected function genParamsMultipart(): array
    {
        $multipart = [];
        foreach ($this->params as $name => $contents) {
            if (is_array($contents)) continue;
            $multipart[] = [
                'name' => $name,
                'contents' => $contents
            ];
        }

        return $multipart;
    }

    protected function genParamsForm(): array
    {
        return $this->params;
    }

    protected function setEntryUrl(string $entryUrl){
        $this->entryUrl = rtrim($entryUrl, '/');
    }

    protected function genRequestUrl()
    {
        $this->requestUrl = $this->entryUrl . '/' . $this->methodName;
    }

    protected function getContent()
    {
        if ($this->response->getStatusCode() > 400) return false;

        $content = json_decode($this->response->getBody()->getContents());

        return $content ?? false;
    }
}