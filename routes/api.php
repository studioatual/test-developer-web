<?php

$app->group('/api/clients', function () {
    $this->group('/{id}', function () {
        $this->get('[/]', 'Api.ClientsController:show');
        $this->put('[/]', 'Api.ClientsController:update');
        $this->delete('[/]', 'Api.ClientsController:destroy');
    });
    
    $this->get('[/]', 'Api.ClientsController:index');
    $this->post('[/]', 'Api.ClientsController:store');
});