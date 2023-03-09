<?php
defined('TYPO3_MODE') || die();


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
    'sysmon2',
    'sysmon2',
    '',
    '',
    [
        \Homeinfo\SysMon2\Controller\UnauthenticatedAccess::class => 'systemDetails',
    ],
    [
        'access' => 'user',
        'labels' => 'LLL:EXT:sysmon2/Resources/Private/Language/locallang_be.xlf:backend.checkresults.label',
        'inheritNavigationComponentFromMainModule' => false,
        'standalone' => true,
    ]
);