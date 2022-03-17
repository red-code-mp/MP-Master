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
        $this->bindRequest();
    }
}
