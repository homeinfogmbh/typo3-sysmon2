<?php
if (!defined('TYPO3_MODE')) { die('Access denied.'); }

$extensionKey = 'sysmon2';

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'sysmon2',
    'SysMon2',
    'SysMon2',
    'EXT:'.$extensionKey.'/Resources/Public/Icons/Extension.svg'
);
?>