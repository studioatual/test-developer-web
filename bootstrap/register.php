<?php

$container['HomeController'] = function ($c) {
    return new App\Controllers\HomeController($c);
};

$container['Api.ClientsController'] = function ($c) {
    return new App\Controllers\Api\ClientsController($c);
};

$container['validator'] = function ($container) {
    return new App\Validation\Validator;
};