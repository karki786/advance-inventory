<?php
/**
 * Created by PhpStorm.
 * User: dwanyoike
 * Date: 06/Jul/2017
 * Time: 9:23 PM
 */

echo 'Current PHP version: ' . phpversion();
echo "<br/>";
if (!defined('PDO::ATTR_DRIVER_NAME')) {
    echo 'PDO unavailable';
} else {
    echo 'PDO Installed';
}
