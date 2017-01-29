<?php

// comment out the following two lines when deployed to production
if ($_SERVER['SERVER_NAME'] == 'youtube-dl.yii') {
  defined('YII_DEBUG') or define('YII_DEBUG', true);
  defined('YII_ENV') or define('YII_ENV', 'dev');
}

if (substr($_SERVER['SERVER_NAME'], -19) == 'online-converter.us') {
  defined('LANGUAGE') or define('LANGUAGE', 'en');
}
elseif (substr($_SERVER['SERVER_NAME'], -3) == '.us') {
  defined('LANGUAGE') or define('LANGUAGE', 'en');
}
elseif (substr($_SERVER['SERVER_NAME'], -3) == '.cz') {
  defined('LANGUAGE') or define('LANGUAGE', 'cz');
}
else {
  defined('LANGUAGE') or define('LANGUAGE', 'sk');
}

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');

(new yii\web\Application($config))->run();
