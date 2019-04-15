<?php defined('SYSPATH') OR die('No direct access allowed.');

class Json_Api_Request_Params {

    private function __construct(){}

    /**
     * Json_Api_Request_Params constructor.
     * @param string $entity_name Название сущности, для которой собираеться список параметров. Может быть как основная сущность, так и сущность из зависимостей
     * @param array $args массив пришедших параметров
     * @throws Exception
     */
    static function get(string $entity_name, array $args){
        $args['page'] = (isset($args['page'])) ? $args['page'] : [];
        $args['fields'] = (isset($args['fields'])) ? explode(',', $args['fields']) : [];
        $args['filters'] = (isset($args['filters'])) ? $args['filters'] : [];
        $args['sort'] = (isset($args['sort'])) ? explode(',', $args['sort']) : [];

        $ret = [
            'page' => new Json_Api_Request_Params_Page($entity_name, $args['page']),
            'fields' => new Json_Api_Request_Params_Fields($entity_name, $args['fields']),
            'filters' => new Json_Api_Request_Params_Filters($entity_name, $args['filters']),
            'sort' => new Json_Api_Request_Params_Sort($entity_name, $args['sort']),
        ];

        return $ret;
    }

    static function getParam(string $entity_name, array $args, string $param_name){
        $class = 'Json_Api_Request_Params_' . ucfirst(strtolower($param_name));

        if(class_exists($class)){
            return new $class($entity_name, $args);
        }

        return NULL;
    }
}