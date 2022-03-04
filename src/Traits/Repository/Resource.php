<?php


namespace MP\Base\Traits\Repository;


use MP\Base\Models\Base;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Str;

trait Resource
{

    /**
     * repo's resource
     *
     * @author Amr
     * @var string
     */
    protected $resource = \MP\Base\Http\Resources\Resource::class;

    /**
     * get repo's resource
     *
     * @return mixed|string
     * @throws RequestNotFoundException
     * @author Amr
     */
    protected function __getResourceClass()
    {
        if ($this->resource !== \MP\Base\Http\Resources\Resource::class && $this->resource != null)
            return $this->resource;
        return $this->__predicateResource();
    }

    /**
     * this function tries to predicate resource according
     * to the structure of packages
     *
     * @return mixed
     *
     * @throws \ReflectionException
     * @author Amr
     */
    private function __predicateResource()
    {
        return $this->__predicateClass('resource');
    }

    /**
     * publish resource
     *
     * @return mixed|string
     */
    public function getResource()
    {
        return $this->__getResourceClass();
    }

    /**
     * predicate resource's method
     *
     * @param $name
     * @return string
     * @author Amr
     */
    function getResourceMethod($name)
    {
        if (request()->has('resource'))
            return request()->get('resource');
        return 'serializeFor' . Str::camel($name ?: $this->getActionMethod());
    }

    /**
     * parse the data according to the appropriate structure
     *
     * @param $data
     * @param bool $isList
     * @return mixed
     * @author Amr
     */
    function collection($data, $isList = false, $name = null)
    {
        $resource = $this->getResource();
        if ($isList)
            return $this->__serializeListCollection($resource, $data, $name);
        return (new $resource($data))->{$this->getResourceMethod($name)}(request());
    }

    /**
     * this function transform list to the appropriate structure
     * but if that list is a pagination list
     * I re-structure the pagination into the following one
     * data : []
     * paginator : {
     * ...attributes
     * }
     * @param $resource
     * @param $data
     * @return array
     */
    private function __serializeListCollection($resource, $data, $name)
    {
        if (!($data instanceof AbstractPaginator))
            return $resource::collection($data)->map->{$this->getResourceMethod($name)}(request());
        $collection = $data->getCollection();

        $collection = $resource::collection($collection)->map->{Str::camel($this->getResourceMethod($name))}(request());
        $data = $data->toArray(); // convert paginator's object to array to re-structure it @author Amr
        unset($data['data']);
        return [
            'data' => $collection,
            'paginator' => $data
        ];

    }
}
