<?php


namespace MP\Base\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

abstract class Resource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }


    /**
     * return the toArray function if this class
     * doesn't have the called function
     *
     * @param string $method
     * @param array $parameters
     * @return array|mixed
     * @author Amr
     */
    public function __call($method, $parameters)
    {
        return $this->toArray(request());
    }
}
