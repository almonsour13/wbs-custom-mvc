<?php
// Define your custom routes
$router->addRoute('GET', '/', 'pageController', 'dashboard');
$router->addRoute('GET', 'dashboard', 'pageController', 'dashboard');
$router->addRoute('GET', 'consumer', 'pageController', 'consumer');
$router->addRoute('GET', 'add-consumer', 'pageController', 'addConsumer');
$router->addRoute('GET', 'edit-consumer', 'pageController', 'editConsumer');
?>