<?php
return [
    'routes' => [
        ['name' => 'page#index', 'url' => '/', 'verb' => 'GET'],
        ['name' => 'portfolio#index', 'url' => '/notes', 'verb' => 'GET'],
        ['name' => 'portfolio#show', 'url' => '/notes/{id}', 'verb' => 'GET'],
        ['name' => 'portfolio#create', 'url' => '/notes', 'verb' => 'POST'],
        ['name' => 'portfolio#update', 'url' => '/notes/{id}', 'verb' => 'PUT'],
        ['name' => 'portfolio#destroy', 'url' => '/notes/{id}', 'verb' => 'DELETE']
    ]
];


