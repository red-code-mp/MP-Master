<?php


namespace MP\Base\Traits\Repository\CRUD;


use MP\Base\Exceptions\MethodNotFoundException;

trait Unknown
{
    /**
     * handel the unregistered methods
     *
     * @param $name
     * @param $arguments
     * @throws MethodNotFoundException
     * @author Amr
     */
    public function __call($name, $arguments)
    {
        $result = method_exists($this, '__extra');
        if (!$result)
            throw new MethodNotFoundException('undefined method ' . $name);
        $this->__extra(...$arguments);
    }
}
