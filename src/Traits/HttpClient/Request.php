<?php


namespace MP\Base\Traits\HttpClient;


use GuzzleHttp\Client;

trait Request
{
    use \MP\Base\Traits\HttpClient\Client, Options, RequestBody;
}
