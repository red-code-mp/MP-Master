<?php


namespace MP\Base\Traits;


use Illuminate\Support\Str;

trait Translation
{
    /**
     * get model's name to be translated in all
     * response messages
     *
     * @return string
     * @author Amr
     */
    function __getModelName()
    {
        return Str::lower($this->getRepository()->getModelName());
    }

    /**
     * translate the name of model
     * @return array|\Illuminate\Contracts\Translation\Translator|string|null
     * @author Amr
     */
    public function getTranslatedName()
    {
        return trans($this->__getModelFromModuleName() . '::lang.' . $this->__getModelName());
    }

}
