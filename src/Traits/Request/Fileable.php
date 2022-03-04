<?php


namespace MP\Base\Traits\Request;


trait Fileable
{
    /**
     * called before prepareForValidation method
     */
    public function beforePreparation()
    {

    }

    /**
     * validation passed
     * @author Amr
     */
    public function prepareForValidation()
    {
        $this->beforePreparation();
        $this->merge(['user_id' => authenticated_id()]);
        $hasFile = $this->hasFiles();
        if (!$hasFile)
            return;
        $this->parseAttributes();

    }

    /**
     * check if request's has files
     * @return bool
     * @author Amr
     */
    function hasFiles()
    {
        return collect($this->allFiles())->isNotEmpty();
    }

    /**
     * parse request's attributes if one of attributes is a file
     * @author Amr
     */
    function parseAttributes()
    {
        collect($this->all())->each(function ($attr, $key) {
            $value = $attr;
            if (is_json($attr))
                $value = json_decode($attr, true);
            $this->request->set($key, $value);
        });
    }
}
