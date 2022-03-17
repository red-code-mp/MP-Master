<?php


namespace MP\Base\Traits\Controller;


trait Repository
{
    /**
     * controller's repository
     *
     * @author Amr
     * @var string
     */
    protected $repository = \MP\Base\Repositories\Repository::class;

    /**
     * get controller's  repository
     * @return mixed|string
     * @throws RequestNotFoundException
     * @author Amr
     */
    function getRepository()
    {
        if ($this->repository !== \MP\Base\Repositories\Repository::class && $this->repository != null)
            return new $this->repository();
        $class = $this->__predicateRepository();
        return new $class();
    }

    /**
     * this function tries to predicate repository according
     * to the structure of packages
     *
     * @return mixed
     * @throws RequestNotFoundException
     * @throws \ReflectionException
     * @author Amr
     */
    private function __predicateRepository()
    {
        return $this->__predicateClass('repository');
    }
}
