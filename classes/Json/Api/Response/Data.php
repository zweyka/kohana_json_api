<?php defined('SYSPATH') OR die('No direct access allowed.');

class Json_Api_Response_Data {
    protected $_data;

    public function __construct(){
        $this->_data = [];
    }

    public function set(array $val){
        $this->_data[] = $val;
    }

    public function as_array(){
        return $this->_data;
    }
}