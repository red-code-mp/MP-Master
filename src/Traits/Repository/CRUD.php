<?php


namespace MP\Base\Traits\Repository;


use MP\Base\Traits\Repository\CRUD\Delete;
use MP\Base\Traits\Repository\CRUD\Fetch;
use MP\Base\Traits\Repository\CRUD\Relations;
use MP\Base\Traits\Repository\CRUD\Store;
use MP\Base\Traits\Repository\CRUD\Unknown;
use MP\Base\Traits\Repository\CRUD\Update;

trait CRUD
{
    use Relations, Store, Update, Delete, Fetch, Unknown;
}
