<?php

$app->get('/', 'App\Controllers\HomeController:index')->setname('home');

$app->group('', function() use ($app, $container) {
// ------------ Routing User ---------------------- //
		$app->post('/user/register', 'App\Controllers\UserController:register')->setName('user.register');

		$app->post('/user/login', 'App\Controllers\UserController:login')->setName('user.login');
		$app->post('/user/logout', 'App\Controllers\UserController:logout')->setName('user.logout');


$app->group('', function() use ($app, $container) {
// ------------ Routing Book ----------------------- //


		$app->get('/book/list', 'App\Controllers\BookController:index')->setname('book.list');

		$app->get('/book/{id}', 'App\Controllers\BookController:findBook')->setname('book.find');

		$app->post('/book/add', 'App\Controllers\BookController:addBook')->setname('book.add');

		$app->put('/book/update/{id}', 'App\Controllers\BookController:updateBook')->setname('book.update');

		$app->delete('/book/delete/{id}', 'App\Controllers\BookController:delete')->setname('book.hardDelete');


		$app->get('/book/upload/{id}', 'App\Controllers\BookController:uploadBook')->setname('book.upload');

// ------------ Routing Book Sold And Buy Book -------------------- //


		$app->get('/book/list/sold', 'App\Controllers\BookController:bookSold')->setname('book.list.sold');

		$app->post('/book/buy/{id}', 'App\Controllers\BookController:buyBook')->setname('book.buy');


$app->group('', function() use ($app, $container) {
// ------------ Routing Category -------------------- //

		$app->get('/category/list', 'App\Controllers\CategoryController:index')->setname('category.list');

		$app->post('/category/add', 'App\Controllers\CategoryController:addcategory')->setname('category.add');

		$app->put('/category/update/{id}', 'App\Controllers\CategoryController:updateCategory')->setname('category.update');

		$app->delete('/category/delete/{id}', 'App\Controllers\CategoryController:delete')->setname('category.hardDelete');

		})->add(new \App\Middlewares\AdminMiddleware($container));
	})->add(new \App\Middlewares\AuthToken($container));
});



