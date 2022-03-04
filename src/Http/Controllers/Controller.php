<?php

namespace MP\Base\Http\Controllers;

use MP\Base\Traits\Base;
use MP\Base\Traits\Controller\Attributes;
use MP\Base\Traits\Controller\CRUD;
use MP\Base\Traits\Controller\Init;
use MP\Base\Traits\Controller\Middleware;
use MP\Base\Traits\Controller\Notifiable;
use MP\Base\Traits\Translation;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use Base,
        Attributes,
        CRUD,
        Translation,
        Init;
}
