<?php

define("DOMAIN", $_SERVER['SERVER_NAME']);

// comment out the following two lines when deployed to production
if (DOMAIN == 'youtube-dl.yii') {
  defined('YII_DEBUG') or define('YII_DEBUG', true);
  defined('YII_ENV') or define('YII_ENV', 'dev');
}

if (substr(DOMAIN, -19) == 'online-converter.us') {
  defined('LANGUAGE') or define('LANGUAGE', 'en');
  defined('IS_FINAL_DOMAIN') or define('IS_FINAL_DOMAIN', true);
}
elseif (substr(DOMAIN, -3) == '.us') {
  defined('LANGUAGE') or define('LANGUAGE', 'en');
  defined('IS_FINAL_DOMAIN') or define('IS_FINAL_DOMAIN', false);
}
elseif (substr(DOMAIN, -3) == '.cz') {
  defined('LANGUAGE') or define('LANGUAGE', 'cz');
  defined('IS_FINAL_DOMAIN') or define('IS_FINAL_DOMAIN', false);
}
elseif (substr(DOMAIN, -3) == '.sk') {
  defined('LANGUAGE') or define('LANGUAGE', 'sk');
  defined('IS_FINAL_DOMAIN') or define('IS_FINAL_DOMAIN', false);
}
else {
  defined('LANGUAGE') or define('LANGUAGE', 'sk');
  defined('IS_FINAL_DOMAIN') or define('IS_FINAL_DOMAIN', true);
}


require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');

(new yii\web\Application($config))->run();
