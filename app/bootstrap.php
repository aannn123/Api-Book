<?php 

session_start();

require __DIR__. '/../vendor/autoload.php';

use Slim\App;

$app = new App([
	'settings'	=> require __DIR__. '/setting.php'
	]);

require __DIR__. '/container.php';
require __DIR__. '/routing.php';