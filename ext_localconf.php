<?php
defined('TYPO3_MODE') || die();

$extensionKey = 'sysmon2';

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'sysmon2',
    'SysMon2',
    [
        \Homeinfo\SysMon2\Controller\DebugController::class => 'debug',
    ],
);