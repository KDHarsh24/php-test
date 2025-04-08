<?php

use Bramus\Router\Router;
use App\Controllers\RecipeController;
use App\Controllers\AuthController;
use App\Controllers\RatingController;

$router = new Router();
$router->get('/', function () {
    echo 'Hello World!';
});
$router->get('/recipes', function () {
    // echo 'Hello';
    print_r($_GET, 'Hello');
    (new RecipeController)->index();
});

$router->post('/recipes', function () {
    (new RecipeController)->create();
});

$router->get('/recipes/(\d+)', function ($id) {
    (new RecipeController)->show($id);
});

$router->put('/recipes/(\d+)', function ($id) {
    (new RecipeController)->update($id);
});

$router->delete('/recipes/(\d+)', function ($id) {
    (new RecipeController)->delete($id);
});

$router->post('/recipes/(\d+)/rating', function ($id) {
    (new RatingController)->rate($id);
});

$router->post('/login', function () {
    (new AuthController)->login();
});

$router->run();
