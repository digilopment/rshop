<?php
declare(strict_types=1);

use Cake\Chronos\Chronos;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;

require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . '/config/bootstrap.php';

if (empty($_SERVER['HTTP_HOST']) && !Configure::read('App.fullBaseUrl')) {
    Configure::write('App.fullBaseUrl', 'http://localhost');
}


if (!ConnectionManager::getConfig('test')) {
    ConnectionManager::setConfig('test', [
        'className' => 'Cake\Database\Connection',
        'driver' => 'Cake\Database\Driver\Sqlite',
        'database' => ':memory:',
        'encoding' => 'utf8',
        'cacheMetadata' => true,
        'quoteIdentifiers' => false,
    ]);
}


ConnectionManager::setConfig('test_debug_kit', [
    'className' => 'Cake\Database\Connection',
    'driver' => 'Cake\Database\Driver\Sqlite',
    'database' => TMP . 'debug_kit.sqlite',
    'encoding' => 'utf8',
    'cacheMetadata' => true,
    'quoteIdentifiers' => false,
]);
ConnectionManager::alias('test_debug_kit', 'debug_kit');

Chronos::setTestNow(Chronos::now());

session_id('cli');

if (PHP_SAPI !== 'cli' || (defined('PHPUNIT_RUNNING') && PHPUNIT_RUNNING)) {
    \Cake\TestSuite\ConnectionHelper::addTestAliases();
    (new \Migrations\TestSuite\Migrator())->run();
}
