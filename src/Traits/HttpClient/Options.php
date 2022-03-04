<?php


namespace MP\Base\Traits\HttpClient;


trait Options
{
    /**
     * request's header
     * @author Amr
     * @var array
     */
    protected $requestHeader = [];

    /**
     * request's options
     * @author Amr
     * @var array
     */
    protected $requestOptions = [];

    /**
     * @return array
     */
    public function getRequestHeader(): array
    {
        return $this->requestHeader;
    }

    /**
     * @param array $requestHeader
     */
    public function setRequestHeader(array $requestHeader): void
    {
        $this->requestHeader = $requestHeader;
    }


    /**
     * @return array
     */
    public function getRequestOptions(): array
    {
        $options = $this->requestOptions;
        $options['headers'] = $this->getRequestHeader();
        return $options;
    }

    /**
     * @param array $requestOptions
     */
    public function setRequestOptions(array $requestOptions): void
    {
        $this->requestOptions = $requestOptions;
    }

}
