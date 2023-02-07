<?php
defined('TYPO3_MODE') || die();


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
    'sysmon2',
    'SysMon2',
    '',
    '',
    [
        \Homeinfo\SysMon2\Controller\UnauthenticatedAccess::class => 'listLastMonth',
    ],
    [
        'access' => 'user',
        'labels' => 'LLL:EXT:SysMon2/Resources/Private/Language/locallang_be.xlf:backend.checkresults.label',
        'inheritNavigationComponentFromMainModule' => false,
        'standalone' => true,
    ]
);