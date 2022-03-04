<?php


namespace MP\Base\Traits\Repository;


trait Query
{
    /**
     * the that used to order records by
     *
     * @author Amr
     * @var string
     */
    protected $orderedColumn = 'updated_at';
    /**
     * the way records should be ordered by
     * @author Amr
     * @var string
     */
    protected $orderBy = 'desc';

    /**
     * @return string
     */
    public function getOrderedColumn(): string
    {
        return $this->orderedColumn;
    }

    /**
     * @return string
     */
    public function getOrderBy(): string
    {
        return $this->orderBy;
    }

    /**
     * get teh native query form model
     *
     * @return mixed
     * @author Amr
     */
    protected function __getModelBaseQuery()
    {
        return $this->getModel()->query();
    }

    /**
     * function appended with each query
     *
     * @param $query
     * @author Amr
     */
    protected function baseQuery($query)
    {
    }

    /**
     * function appended with store query
     *
     * @param $query
     * @author Amr
     */
    protected function storeQuery($query)
    {
    }

    /**
     * function appended with find query
     *
     * @param $query
     * @author Amr
     */
    protected function findQuery($query)
    {

    }

    /**
     * function appended with update query
     *
     * @param $query
     * @author Amr
     */
    protected function updateQuery($query)
    {
    }

    /**
     * function appended with delete query
     *
     * @param $query
     * @author Amr
     */
    protected function deleteQuery($query)
    {
    }

    /**
     * function appended with show query
     *
     * @param $query
     * @author Amr
     */
    protected function showQuery($query)
    {
    }

    protected function with()
    {
        return [];
    }

    protected function findWith()
    {
        return [];
    }

    protected function showWith()
    {
        return [];
    }

    protected function storeWith()
    {
        return [];
    }

    protected function updateWith()
    {
        return [];
    }

    protected function deleteWith()
    {
        return [];
    }

    protected function indexWith()
    {
        return [];
    }

    /**
     * the final query to be performed
     *
     * @author Amr
     */
    protected function query()
    {
        return $this->__loadQuery()->with($this->__loadRelation());
    }

    /**
     * get the single model according
     * to the given id
     *
     * @param $id
     * @return mixed
     * @author Amr
     */
    protected function findModel($id)
    {
        return $this->query()->findOrFail($id);
    }

    /**
     * merge the custom queries with the
     * model's native query
     *
     * @return mixed
     * @author Amr
     */
    private function __loadQuery()
    {
        return $this->__getModelBaseQuery()->where(function ($query) {
            $this->baseQuery($query);
            $methodName = $this->getActionMethod() . 'Query';
            if (method_exists($this, $methodName))
                $this->{$methodName}($query);
        });
    }


    /**
     * merge the relation of base relation with
     * method's custom relation
     *
     * @return mixed
     * @author Amr
     */
    private function __loadRelation()
    {
        $methodName = $this->getActionMethod() . 'With';
        $customWith = [];
        if (method_exists($this, $methodName))
            $customWith = $this->{$methodName}();
        return array_merge($this->with(), $customWith);
    }
}
