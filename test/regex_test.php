<?php
/**
 * Created by PhpStorm.
 * User: xuanskyer <furthestworld@icloud.com>
 * Time: 2016-06-11 14:21
 */

$crontab_string  = '0 * * * * *';
$res = preg_match('/^((\*(\/[0-9]+)?)|[0-9\-\,\/]+)\s+((\*(\/[0-9]+)?)|[0-9\-\,\/]+)\s+((\*(\/[0-9]+)?)|[0-9\-\,\/]+)\s+((\*(\/[0-9]+)?)|[0-9\-\,\/]+)\s+((\*(\/[0-9]+)?)|[0-9\-\,\/]+)\s+((\*(\/[0-9]+)?)|[0-9\-\,\/]+)$/i', trim($crontab_string), $matches);

var_dump($res);
var_dump($matches);