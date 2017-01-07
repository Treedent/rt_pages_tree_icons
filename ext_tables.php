<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}
/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2017 Regis TEDONE <regis.tedone@gmail.com>, CMS-PACA
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/


use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use CMSPACA\RtPagesTreeIcons\Hooks\ClickMenuAction;

if ( TYPO3_MODE == 'BE' ) {

    ExtensionManagementUtility::registerExtDirectComponent(
        'TYPO3.RtPagesTreeIcons.ClickmenuAction',
        'CMSPACA\\RtPagesTreeIcons\\Hooks\\ClickMenuAction'
    );

    //Load JS File for page tree contextuel menu interactions.
    $GLOBALS[ 'TBE_MODULES' ][ '_configuration' ][ $_EXTKEY ][ 'jsFiles' ][ 'TreeActions' ] = 'EXT:rt_pages_tree_icons/Resources/Public/Js/PagesTreeActions.js';
    ClickMenuAction::addContextMenuItems();
}

call_user_func(
    function($extKey) {

        if (TYPO3_MODE === 'BE') {

            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
                'CMSPACA.' . $extKey,
                'web',
                'mod1',
                '',
                [
                    'PageIcons' => 'list,changepageicon,editPageProperties'
                ],
                [
                    'access' => 'user,group',
                    'icon'   => 'EXT:' . $extKey . '/Resources/Public/Icons/palm-tree-BE.svg',
                    'labels' => 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_rtpim.xlf',
                ]
            );

        }
        //Load Extension Typoscipt Configuration
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($extKey, 'Configuration/TypoScript', 'rt_pages_tree_icons');
    },
    $_EXTKEY
);