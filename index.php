<?php
define('APP_PATH', __DIR__ . '/');
define('CONF_PATH', APP_PATH . 'conf/');

$app = new Yaf_Application(APP_PATH . 'conf/application.ini');
$app->bootstrap()->run();
