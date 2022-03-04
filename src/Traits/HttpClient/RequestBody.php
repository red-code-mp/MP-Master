<?php


namespace MP\Base\Traits\HttpClient;


trait RequestBody
{
    /**
     * client's instance
     * @author Amr
     * @var null
     */
    protected static $clientRequest = null;

    /**
     * send request
     * @param $method
     * @param $endpoint
     * @return mixed
     * @author Amr
     */
    public function request($method, $endpoint)
    {
        $response = $this->getClient()->request($method, $endpoint, $this->getRequestOptions());
        return $this->__parseBody($response->getBody());
    }

    /**
     * parse the body of request
     * @param $body
     * @return mixed
     * @author Amr
     */
    function __parseBody($body)
    {
        return json_decode($body, true);
    }
}
