<?php


namespace MP\Base\Traits\Repository\CRUD;


trait Relations
{
    /**
     * request's attribute
     * @var null
     * @author Amr
     */
    protected $relation = null;
    /**
     * model's method
     * @var null
     * @author Amr
     */
    protected $relationMethod = null;

    /**
     * get relation tag from request
     * @return null
     * @author Amr
     */
    public function getRelation()
    {
        return $this->relation;
    }

    /**
     * get relation method from model
     * @return null
     * @author Amr
     */
    public function getRelationMethod()
    {
        return $this->relationMethod ?? $this->relation;
    }

    /**
     * check if model needs relation operations
     * @return bool
     * @author Amr
     */
    function hasRelation()
    {
        return !empty($this->getRelation());
    }

}
