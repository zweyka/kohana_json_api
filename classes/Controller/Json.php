<?php

/**
 * Class Controller_Json
 * От него наследуються все контроллеры JsonApi
 */
class Controller_Json
{
    protected $response;

    protected $request;

    public function __construct(Json_Api_Request &$request, Json_Api_Response &$response){
        $this->request = $request;
        $this->response = $response;
    }
}