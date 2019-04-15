<?php defined('SYSPATH') OR die('No direct access allowed.');

class Json_Api_Request_Params_Fields extends Json_Api_Request_Params_Param {

    protected $_param_name = 'fields';

    public function set(string $key, $val){
        $this->_data[$key] = trim($val);
    }
}