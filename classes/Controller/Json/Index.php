<?php

/**
 * Точка входа для всех запросов к JsonApi.
 * Class Controller_Json_Index
 */
class Controller_Json_Index extends Controller_Json_Api {

    public function action_index(){
        // check Class from "method" params
        $class_name = 'Api_Json_' . ucfirst(strtolower($this->_request->controller()));
        if(class_exists($class_name)){
            $class = new $class_name($this->_request, $this->_response);

            $method = 'action_' . $this->_request->action();
            // check action from "method" params
            if(in_array($method, get_class_methods(get_class($class)))){
                // get "method"
                $class->$method();
            } else {
                throw new Exception('Method does not exist');
            }
        } else {
            throw new Exception('Method does not exist');
        }
    }

}