<?php defined('SYSPATH') OR die('No direct access allowed.');

class Json_Api_Response {
    protected $data;

    protected $_included = [];

    protected $_errors = [];

    public function __construct(){
        $this->data = new Json_Api_Response_Data();
    }

    public function errors($val = null){
        if(is_null($val)){
            return $this->_errors;
        }

        $this->_errors[] = $val;
    }

    public function setData(array $val){
        // если есь зависимости
        if(isset($val['included'])){
            foreach($val['included'] as $entity_name => &$v){
                $this->setInclude($entity_name, $v);
                unset($v['attributes']);
            }

        }

        $this->data->set($val);
    }

    public function setInclude(string $entity, array $val){
        if(!isset($this->_included[$entity])){
            $this->_included[$entity] = [];
        }

        if(isset($val['id'])){
            $this->_included[$entity][$val['id']] = $val;
        } else {
            $this->_included[$entity][] = $val;
        }

        return true;
    }

    public function getIncludes($key = NULL){
        if(is_null($key)){
            $ret = [];

            foreach($this->_included as $k => $v){
                $ret[$k] = $this->getIncludes($k);
            }
            return $ret;
        }

        return (isset($this->_included[$key])) ? array_values($this->_included[$key]) : NULL ; // приводим ассоциативный массив к списку
    }

    public function execute(){
        return [
            'data' => $this->data->as_array(),
            'included' => $this->getIncludes(),
            'errors' => $this->_errors,
        ];
    }
}