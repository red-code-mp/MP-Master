<?php


namespace MP\Base\Traits\Controller;


use Illuminate\Support\Facades\Route;

trait Init
{
    /**
     * Controller's constructor.
     * @author Amr
     */
    public function __construct()
    {
        $this->prepareMiddleware();
        $this->bindRequest();
    }

    /**
     * @author khalid
     * transaction  middleware
     */
    public function prepareMiddleware()
    {
        $model = $this->getRepository()->__getModelClass();
    }
}
