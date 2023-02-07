<?php
defined('TYPO3_MODE') || die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'sysmon2',
    'LastMonth',
    [
        \Homeinfo\SysMon2\Controller\UnauthenticatedAccess::class => 'listLastMonth',
    ],
);