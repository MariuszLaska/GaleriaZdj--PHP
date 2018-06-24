<?php


function dispatch($routing, $action_url)
{
    $controller_name = $routing[$action_url];

    $model = [];
    $view_name = $controller_name($model);

    render($view_name, $model);
}


function render($view_name, $model)
{
    global $routing;
    extract($model);
    include 'views/' . $view_name . '.php';
}