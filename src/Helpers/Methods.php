<?php


if (!function_exists('is_json')) {
    /**
     * check if the string is json
     * @param $data
     * @return bool
     * @author Amr
     */
    function is_json($data)
    {
        return is_string($data) && is_array(json_decode($data, true)) && (json_last_error() == JSON_ERROR_NONE);
    }
}
if (!function_exists('db_transaction')) {
    /**
     * encapsulate all system db transactions
     * @param $data
     * @return bool
     * @author Amr
     */
    function db_transaction($function)
    {
        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            $result = $function();
            \Illuminate\Support\Facades\DB::commit();
            return $result;
        } catch (\Exception $exception) {
            \Illuminate\Support\Facades\DB::rollBack();
            throw $exception;
        }
    }
}
if (!function_exists('new_object')) {
    /**
     * create new object from array of strings
     * @param $data
     * @return bool
     * @author Amr
     */
    function new_object(array $attributes): array
    {
        return array_fill_keys($attributes, null);
    }
}

if (!function_exists('replaceArrayKey')){
    /**
     * @author khalid
     * @param $array
     * @param $oldKey
     * @param $newKey
     * @return array
     */
    function replaceArrayKey($array, $oldKey, $newKey){
        //If the old key doesn't exist, we can't replace it...
        if(!isset($array[$oldKey])){
            return $array;
        }
        //Get a list of all keys in the array.
        $arrayKeys = array_keys($array);
        //Replace the key in our $arrayKeys array.
        $oldKeyIndex = array_search($oldKey, $arrayKeys);
        $arrayKeys[$oldKeyIndex] = $newKey;
        //Combine them back into one array.
        $newArray =  array_combine($arrayKeys, $array);
        return $newArray;
    }
}
if (!function_exists('base_name')) {
    /**
     * @author khalid
     * @param $path
     */
    function base_name($path)
    {
        $base = explode('\\', $path);
        return end($base);
    }
}
