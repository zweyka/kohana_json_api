<?php defined('SYSPATH') OR die('No direct access allowed.');

return array(
    'default' => [
        'params' => [
            'page' => [
                'size' => 25,
                'number' => 1
            ],
            'relation' => [],
            'fields' => [],
            'filters' => [],
            'sort' => [],
        ]
    ],
/*
    'posts' => [
        // спиосок доступных для запроса полей
        'fields_available' => ['id','name','description','price','count','is_new','category','date_add','rating','buy_count','views','seller','status'],
        // список параметров, которые применяються к каждому запросу
        'params' => [
            'default' => [
                'page' => [],
                'relation' => [],
                // список отправляемых полей по умолчанию
                'fields' => ['id','name','description','price'],
                // настройки фильтрации по умолчанию
                'filters' => [
                    'is_published' => true
                ],
                // настройки сортировки по умолчанию
                'sort' => [
                    'date_add' => 'ASC',
                    'rating' => 'ASC'
                ],
            ]
        ]
    ],
*/

);
