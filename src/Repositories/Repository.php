<?php

namespace MP\Base\Repositories;

use MP\Base\Traits\Base;
use MP\Base\Traits\Repository\CRUD;
use MP\Base\Traits\Repository\Model;
use MP\Base\Traits\Repository\Notifiable;
use MP\Base\Traits\Repository\Query;
use MP\Base\Traits\Repository\Request as RequestTrait;

use MP\Base\Traits\Repository\Resource;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;

abstract class Repository
{
    use Base, Model, Query, RequestTrait, Resource, CRUD;

}
