<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3_MODE') || die();

//Load Extension Typoscipt Configuration
ExtensionManagementUtility::addStaticFile('rt_pages_tree_icons', 'Configuration/TypoScript', 'Pages Tree Icons');