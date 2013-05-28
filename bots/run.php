<?php

chdir(dirname(__DIR__));

use Core\ServiceManager\ServiceManager;
use Core\Config\Config;

/* Init autoload */

include 'library/Core/Loader/StandardAutoloader.php';

$loader = new Core\Loader\StandardAutoloader();
$loader->registerNamespace('Application', './Application')
        ->register();

/* Init ServiceManager */

$smConfig       = include 'Application/configs/serviceManager.php';
$serviceManager = new ServiceManager();

foreach ($smConfig['factories'] as $name => $factory) {
    $serviceManager->setFactory($name, $factory);
}

$cfgArray = include 'Application/configs/main.php';
$serviceManager->set('config', new Config($cfgArray));

/* Start transactions */
$tService    = $serviceManager->get('transactionService');
$userService = $serviceManager->get('userService');

$startTime = time();
while (time() < $startTime + 60 * 30) {
    for ($userId = 71; $userId < 101; $userId++) {
        $user = $userService->fetchById($userId);

        try {
            foreach ($tService->fetchUserTemplates($user) as $template) {
                $accountFrom = $userService->fetchAccountByNumber($template->account_from);
                $accountTo   = $userService->fetchAccountByNumber($template->account_to);
                $transaction = $tService->createTransaction($user, $accountFrom, $accountTo, $template->sum);

                $tService->commitTransaction($transaction->id, $user);
                echo "{$accountFrom->number} > {$accountTo->number} > {$template->sum()}\n";
            }

            sleep(rand(0, 5));
        } catch (Exception $e) {
            continue;
        }
    }
    echo "Memory: " . memory_get_usage() . "\n";
}