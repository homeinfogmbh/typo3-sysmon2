<?php
defined('TYPO3_MODE') || die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'SysMon2',
    'SysMon2',
    [
        \Homeinfo\SysMon2\Controller\UnauthenticatedAccess::class => 'listLastMonth',
    ],
);