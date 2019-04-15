<?php defined('SYSPATH') OR die('No direct access allowed.');

abstract class Json_Api_Request_Params_Param {

    protected $_param_name;

    protected $_data;

    public function __construct(string $entity_name, array $args = []){
        $this->_data = $this->getDeafult();

        if(empty($args)){
            $this->_data = array_merge(
                $this->_data,
                $this->getEntityDeafult($entity_name)
            );
        } else {
            foreach ($args as $k => $v){
                $this->set($k, $v);
            }
        }

    }

    /**
     * Возвращает массив значений параметра по умолчанию
     * @return array
     * @throws Kohana_Exception
     */
    protected function getDeafult(){
        return (array)Kohana::$config->load("json_api.default.params.{$this->_param_name}");
    }

    /**
     * Возвращает массив значений параметра по умолчанию для указанной сущности
     * @param string $entity_name
     * @return array
     * @throws Kohana_Exception
     */
    protected function getEntityDeafult(string $entity_name){
        return (array)Kohana::$config->load("json_api.{$entity_name}.params.default.{$this->_param_name}");
    }

    /**
     * Установка значения
     * @param string $key
     * @param $val
     */
    public function set(string $key, $val){
        $this->_data[$key] = $val;
    }

    /**
     *  Возвращает все значения массивом, либо значение конкретного значения
     * @param null $key
     * @return array|null
     */
    public function get($key = NULL){
        if(is_null($key)){
            return (array)$this->_data;
        }

        return (isset($this->_data[$key])) ? $this->_data[$key] : NULL;
    }
}