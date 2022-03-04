<?php


namespace MP\Base\Traits\HttpClient;


trait Client
{
    /**
     * request's base uri
     * @author Amr
     * @var string
     */
    protected $requestBaseUri = '';
    /**
     * client's params
     * @author Amr
     * @var array
     */
    protected $requestClientParams = [];


    /**
     * @return array
     */
    public function getRequestBaseUri(): array
    {
        return ['base_uri' => $this->requestBaseUri];
    }

    /**
     * @param array $requestClientParams
     */
    public function setRequestClientParams(array $requestClientParams): void
    {
        $this->requestClientParams = $requestClientParams;
    }

    /**
     * @param string $requestBaseUri
     */
    public function setRequestBaseUri(string $requestBaseUri): void
    {
        $this->requestBaseUri = $requestBaseUri;
    }

    /**
     * @return array
     */
    public function getRequestClientParams(): array
    {
        return array_merge($this->requestClientParams, $this->getRequestBaseUri());
    }

    /**
     * init the client's instance
     * @return mixed
     * @author Amr
     */
    public function __iniClientRequest()
    {
        if (!static::$clientRequest)
            static::$clientRequest = new \GuzzleHttp\Client($this->getRequestClientParams());
        return static::$clientRequest;

    }

    /**
     * return the generated client request
     * @return mixed
     * @author Amr
     */
    public function getClient()
    {
        return $this->__iniClientRequest();
    }
}
