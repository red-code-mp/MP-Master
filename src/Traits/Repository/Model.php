<?php


namespace MP\Base\Traits\Repository;


use MP\Base\Models\Base;

trait Model
{
    /**
     * repo's model
     *
     * @author Amr
     * @var string
     */
    protected $model = Base::class;

    /**
     * return the name of model
     * @return mixed
     * @author Amr
     */
    public function getModelName()
    {
        $modelPath = explode('\\', $this->__getModelClass());
        return end($modelPath);
    }

    /**
     * get repo's  model
     *
     * @return mixed|string
     * @throws RequestNotFoundException
     * @author Amr
     */
    public function __getModelClass()
    {
        if ($this->model !== Base::class && $this->model != null)
            return $this->model;
        return $this->__predicateModel();
    }

    /**
     * get model's object
     * @return mixed
     * @author Amr
     */
    public function getModel()
    {
        $class = $this->__getModelClass();
        return new $class();
    }

    /**
     * this function tries to predicate model according
     * to the structure of packages
     *
     * @return mixed
     *
     * @throws \ReflectionException
     * @author Amr
     */
    private function __predicateModel()
    {
        return $this->__predicateClass('model');
    }
    /*
     * @author khalid
     * return fillable model
     */
    public function getFillable()
    {
        return $this->getModel()->getFillable();
    }
}
