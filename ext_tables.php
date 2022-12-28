<?php
defined('TYPO3_MODE') || die();


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
    'SysMon2',
    'sysmon2',
    '',
    '',
    [
        \Homeinfo\SysMon2\Controller\DebugController::class => 'index',
    ],
    [
        'access' => 'user',
        'inheritNavigationComponentFromMainModule' => false,
    ]
);