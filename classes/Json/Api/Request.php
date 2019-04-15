<?php defined('SYSPATH') OR die('No direct access allowed.');

class Json_Api_Request {

    protected $_params;

    protected $_controller;
    protected $_action;

    public function __construct(array $data){
        if(empty($data['method'])){
            throw new Exception('Не указан метод');
        } else {
            $route = $this->route($data['method']);
            $this->_controller = $route['controller'];
            $this->_action = $route['action'];
        }

        $this->_params = (empty($data['params'])) ? [] : $data['params'];
    }

    /**
     * Возвращает массив с указанием Controller и Action на основе запрашиваемого метода
     * @return array
     */
    public function route(string $method){
        $ret = [];

        $method = explode('.', $method);
        $ret['controller'] = (!empty($method[0])) ? $method[0] : 'index';
        $ret['action'] = (!empty($method[1])) ? $method[1] : 'index';

        return $ret;
    }

    public function controller(){
        return $this->_controller;
    }

    public function action(){
        return $this->_action;
    }

    public function page($key = NULL, $val = NULL){
        static $page;

        if(is_null($page)) {
            $page = Json_Api_Request_Params::getParam(
                $this->_controller,
                ( (isset($this->_params['page'])) ? $this->_params['page'] : [] ),
                'page'
            );
        }

        if(is_null($key)){
            return $page;
        } elseif(is_null($val)) {
            return (isset($page[$key])) ? $page[$key] : NULL;
        }

        return $page[$key] = $val;
    }

    /**
     * Возвращает массив зависимостей. Если указана сущность в качестве параметра - вернет массив с параметрмаи для этой сущности, если он существует.
     * @param null $key Ключ зависимости (сущность)
     * @return array|null
     * @throws Exception
     */
    public function relation($key = NULL){
        static $relation;

        if(is_null($relation)) {
            $relation = [];
            foreach ($this->_params['relation'] as $k => $v) {
                // если сущность пердана без параметров. В качестве значения
                if(is_string($v) && is_integer($k)){
                    $k = $v;
                    $v = [];
                }

                $relation[$k] = Json_Api_Request_Params::get($k, $v);
            }
        }

        if(is_null($key)){
            return $relation;
        }

        return (isset($relation[$key])) ? $relation[$key] : NULL;
    }

    public function fields($val = NULL){
        static $fields;

        // инициализация
        if(is_null($fields)) {
            $fields_params = isset($this->_params['fields']) ? explode(',', $this->_params['fields']) : [];

            #var_dump($this->_controller);die;

            $fields = Json_Api_Request_Params::getParam(
                $this->_controller,
                $fields_params,
                'fields'
            );
        }

        // получение списка полей
        if(is_null($val)) {
            return $fields;
        }

        // Установка значения
        if(!in_array($val, $fields)){
            //ToDo: Провалидировать приходящий параметр
            $fields[] = trim($val);
        }

        return TRUE;
    }

    public function filters($key = NULL, $val = NULL){
        static $filters;

        // инициализация
        if(is_null($filters)) {
            $filters = Json_Api_Request_Params::getParam(
                $this->_controller,
                ( (isset($this->_params['filters'])) ? $this->_params['filters'] : [] ),
                'filters'
            );
        }

        if(is_null($key)){ // возвращаем список
            return $filters;
        } elseif(is_null($val)) { // возвращаем значение
            return (isset($filters[$key])) ? $filters[$key] : NULL;
        }

        // ToDO: Провалидировать приходящие значения
        // устанавливаем значение
        return $filters[$key] = $val;
    }

    public function sort($val = NULL){
        static $sort;

        // инициализация
        if(is_null($sort)){
            $sort_params = (isset($this->_params['sort'])) ? explode(',', $this->_params['sort']) : [];

            $sort = Json_Api_Request_Params::getParam(
                $this->_controller,
                $sort_params,
                'sort'
            );
        }

        // получение списка полей
        if(is_null($val)) {
            return $sort;
        }

        // Установка значения
        if(!in_array($val, $sort)){
            //ToDo: Провалидировать приходящий параметр
            $field = $val;
            $val = 'ASC';

            if(strpos($field, '-') === 0){
                $val = 'DESC';
                $field = substr($field, 1);
            };


            $sort[$field] = $val;
        }

        return TRUE;
    }

    public function data($key = NULL, $val = NULL){
        static $data;

        // инициализация
        if(is_null($data)) {
            $data = [];

            if(isset($this->_params['data'])){
                if(is_array($this->_params['data'])) {
                    foreach ($this->_params['data'] as $k => $v) {
                        $this->data($k, $v);
                    }
                }
            }
        }

        if(is_null($key)){ // возвращаем список
            return $data;
        } elseif(is_null($val)) { // возвращаем значение
            return (isset($data[$key])) ? $data[$key] : NULL;
        }

        // ToDO: Провалидировать приходящие значения
        // устанавливаем значение
        return $data[$key] = $val;
    }
}