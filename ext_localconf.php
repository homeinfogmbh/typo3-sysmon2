<?php
defined('TYPO3_MODE') || die();

$extensionKey = 'SysMon2';

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'SysMon2',
    'SysMon2',
    [
        \Homeinfo\SysMon2\Controller\DebugController::class => 'index',
    ],
);