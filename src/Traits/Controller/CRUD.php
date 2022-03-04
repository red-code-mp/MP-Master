<?php


namespace MP\Base\Traits\Controller;


use MP\Base\Traits\Controller\CRUD\Delete;
use MP\Base\Traits\Controller\CRUD\Fetch;
use MP\Base\Traits\Controller\CRUD\Store;
use MP\Base\Traits\Controller\CRUD\Unknown;
use MP\Base\Traits\Controller\CRUD\Update;

trait CRUD
{
    use Store, Update, Delete, Fetch, Unknown;
}
