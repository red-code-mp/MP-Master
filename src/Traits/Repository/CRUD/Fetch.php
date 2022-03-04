<?php


namespace MP\Base\Traits\Repository\CRUD;


use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait Fetch
{
    /**
     * model is_active attribute
     * @author Amr
     * @var string
     */
    protected $isActive = 'is_active';

    /**
     * how many rows returned per page
     * @author Amr
     * @var string
     */
    protected $perPage = 30;

    /**
     * model is_active checked value
     * @author Amr
     * @var string
     */
    protected $isActiveValue = 1;

    /**
     * return object's data according to the passed data
     * @param $id
     * @return mixed
     * @author Amr
     */
    function show($id)
    {
        return $this->collection($this->findModel(request()->route('id')));
    }

    /**
     * return object's data according to the passed data
     * @param $id
     * @return mixed
     * @author Amr
     */
    function find($id)
    {
        return $this->findModel($id);
    }

    /**
     * find object data in all table's records
     * @param $id
     * @return mixed
     * @author Amr
     */
    function findWithTrashed($id)
    {
        try {
            return $this->__getModelClass()::withTrashed()->find($id);
        } catch (\Exception $exception) {
            return $this->find($id);
        }
    }

    /**
     * show all resources
     *
     * @return mixed
     * @author Amr
     */
    function index()
    {
        try{
            $model = $this->query()->filter(request())->orderBy($this->getOrderedColumn(), $this->getOrderBy())->paginate($this->perPage);
        }catch (\BadMethodCallException $badMethodCallException){
            $model = $this->query()->orderBy($this->getOrderedColumn(), $this->getOrderBy())->paginate($this->perPage);
        }

        return $this->collection($model, true);
    }

    /**
     * return the query of indexSelect
     *
     * @return mixed
     * @author Amr
     */
    function indexSelectQuery()
    {

        $query = $this->query();
        $query = $this->hasIsActiveColumn($query);
        if (request()->has('except') && is_numeric(request()->get('except')))
            $query = $query->where('id', '<>', request()->get('except'));
        return $query;

    }

    /**
     * this function for adding is active condition to
     * fetching query
     * @param $query
     * @return mixed
     * @author Amr
     */
    function hasIsActiveColumn($query)
    {
        $hasActive = collect($this->getModel()->getFillable())->contains($this->isActive);
        if ($hasActive)
            return $query->where($this->isActive, '=', $this->isActiveValue);
        return $query;
    }

    /**
     * returns options
     *
     * @return mixed
     * @author Amr
     */
    function indexSelect()
    {
        try{
            $model = $this->indexSelectQuery()->filter(request())->orderBy($this->getOrderedColumn(), $this->getOrderBy())->get();
        }catch (\BadMethodCallException $badMethodCallException){
            $model = $this->indexSelectQuery()->orderBy($this->getOrderedColumn(), $this->getOrderBy())->get();
        }
        return $this->collection($model, true, 'indexSelect');
    }


    /**
     * return antecedents data with its their children
     * @param Request $request
     * @return mixed
     * @author Amr
     */
    function antecedents(Request $request)
    {
        $query = $this->query();
        if (!$request->has('tree_search') || $request->get('tree_search') == false) {
            $query = $query->where('parent_id', null);
        }
        try{
            $data = $query
                ->filter(request())->orderBy($this->getOrderedColumn(), $this->getOrderBy())
                ->with(['children'])->get();
        }catch (\BadMethodCallException $badMethodCallException){
            $data = $query->orderBy($this->getOrderedColumn(), $this->getOrderBy())
                ->with(['children'])->get();
        }

        return $this->collection($data, true);
    }
}
