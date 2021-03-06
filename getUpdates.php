<?php

require './vendor/autoload.php';
require './lib/giveaway/giveawaybot.php';
require './lib/giveaway/languages.php';
require './lib/giveaway/data.php';

/*
 * Main script of the Bot using long polling
 * Each request sent ny a telegram client will be parsed here and
 * the respective function will be called
 */

use \WiseDragonStd\HadesWrapper;

// Set error reporting to skip PHP_NOTICE: http://php.net/manual/en/function.error-reporting.php
error_reporting(E_ALL & ~E_NOTICE);

$bot = new GiveawaysBot($token);
$bot->setLocalization($localization);
$bot->setDatabase(new \WiseDragonStd\HadesWrapper\Database($driver, $dbname, $user, $password, $bot));
try {
    $redis = new \Redis();
    $redis->connect('127.0.0.1', 6385);
} catch (RedisException $e) {
   echo $e->getMessage();
}
$bot->redis = $redis;
//$bot->redis->setOption(Redis::OPT_PREFIX, 'Giveaway:');
$bot->inline_keyboard = new \WiseDragonStd\HadesWrapper\InlineKeyboard($bot);
$bot->getUpdatesLocal();
$bot = null;
