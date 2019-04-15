<?php defined('SYSPATH') OR die('No direct access allowed.');

class Json_Api_Request_Params_Sort extends Json_Api_Request_Params_Param {

    protected $_param_name = 'sort';

    /**
     * Установка значения
     * @param string $key
     * @param $val
     */
    public function set(string $key, $val){
        //ToDo: Провалидировать приходящий параметр
        $field = $val;
        $val = 'ASC';

        if(strpos($field, '-') === 0){
            $val = 'DESC';
            $field = substr($field, 1);
        };

        $this->_data[$field] = $val;
    }
}