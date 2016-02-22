<?php

Route::group(['middleware' => ['web']], function ($router) {
    $router->get('/', function() {
       return redirect('search');
    });

    $router->any('search', 'Guest\SearchController@index');
});
