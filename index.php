<?php
define('APP_PATH', __DIR__ . '/');

$app = new Yaf_Application(APP_PATH . 'conf/application.ini');
$app->bootstrap()->run();
