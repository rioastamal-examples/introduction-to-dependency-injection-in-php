<?php
/**
 * Main file to instantiate Application class and run it.
 *
 * @copyright   2018 Rio Astamal <rio@rioastamal.net>
 * @author      Rio Astamal <rio@rioastamal.net>
 * @link        https://github.com/rioastamal/introduction-to-dependency-injection-in-php
 * @license     https://opensource.org/licenses/mit-license.php MIT License
 */
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/Application.php';

use RioAstamal\Examples\DI\Application;

// Instantiate the app
$app = new Application();
echo $app->run($_SERVER, $_POST, $_GET);