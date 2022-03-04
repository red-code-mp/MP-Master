<?php


namespace MP\Base\Traits\Controller;


trait Request
{

    /**
     * controller's request
     *
     * @author Amr
     * @var string
     */
    protected $request = \MP\Base\Http\Requests\Request::class;

    /**
     * get controller's  request
     * @return mixed|string
     * @throws RequestNotFoundException
     * @author Amr
     */
    function getRequest()
    {
        if ($this->request !== \MP\Base\Http\Requests\Request::class && $this->request != null)
            return $this->request;
        return $this->__predicateRequest();
    }

    /**
     * this function tries to predicate request according
     * to the structure of packages
     *
     * @return mixed
     * @throws RequestNotFoundException
     * @throws \ReflectionException
     * @author Amr
     */
    private function __predicateRequest()
    {
        return $this->__predicateClass('request');
    }

    /**
     * bind request with \MP\Base\Http\Requests\Request
     *
     * @throws RequestNotFoundException
     * @author Amr
     */
    function bindRequest()
    {
        app()->bind(\MP\Base\Http\Requests\Request::class, $this->getRequest());
    }

}
